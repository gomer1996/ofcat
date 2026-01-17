<?php

namespace App\Integrations\Samson;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SyncSamsonProducts
{ //&pagination_page=0
    private $baseUrl = "https://api.samsonopt.ru/";
    private $apiKey = "e6f2f9ce0d1bfe7ed8a1fd8658921470";
    private $url = "https://api.samsonopt.ru/v1/sku/190892?api_key=60769b17043981a854f4d6ac667e5ac5&pagination_count=50";

    public function __invoke()
    {
        $this->syncProducts();
    }

    private function syncProducts(): void
    {
        $products = Product::withoutGlobalScopes()->where('integration', 'samson')->get();

        /**
         * @var Product $product
         */
        foreach ($products as $i => $product) {
            try {
                if (!$product->code) {
                    continue;
                }

                $skuData = $this->getSamsonProduct($product->code);

                if (!$skuData) {
                    Log::info('Deleting samson product: ' . $product->code);
                    $product->delete();
                    continue;
                }

                $stock = $this->getStock("idp", $skuData["stock_list"]);
                $price = $skuData["price_list"][0]["value"] ?? 0;

                if ($price <= 0) {
                    continue;
                }

                $product->price = $price;
                $product->stock = $stock;

                $availability = $this->checkAvailabilityByStock($skuData["stock_list"]);

                if ($availability === false) {
                    $product->is_active = 0;
                } else if ($availability && !$product->is_active) {
                    $product->is_active = 1;
                }

                $product->save();
            } catch (\Exception $E) {

            }
            usleep(1000);
        }
    }

    public function fetchSku(string $sku, int $categoryId, ?float $markup): void
    {
        $skuData = null;

        try {
            $skuData = $this->getSamsonProduct($sku);
        } catch (\Throwable $e) {

        }

        if (!$skuData) {
            return;
        }

        $this->createOrUpdateProduct($skuData, $categoryId, $markup);
    }

    private function getSamsonProduct(string $sku): ?array
    {
        $url = $this->buildUrl("v1/sku/" . $sku . '/');
        $res = Http::get($url);
        $data = $res->json();

        if ($res->serverError()) {
            throw new \Exception('Server error');
        }

        return $data["data"][0] ?? null;
    }

    public function parseProperties(array $props): array
    {
        $properties = [];

        foreach ($props as $prop) {
            $properties[$prop["name"]] = $prop["value"];
        }

        return $properties;
    }

    private function getStock(string $key = '', array $stock = [])
    {
        $found = null;

        foreach ($stock as $s) {
            if ($s["type"] == $key) $found = $s;
        }
        if ($found && $found["value"]) {
            return $found["value"];
        }
        return 0;
    }

    private function createOrUpdateProduct(array $sku, int $categoryId, ?float $markup): void
    {
        $body = $this->buildBody($sku, $categoryId, $markup);

        $existingProduct = Product::withoutGlobalScopes()->where(['code' => $sku["sku"], 'integration' => 'samson'])->first();

        if ($existingProduct) {
            $existingProduct->update($body);
        } else {
            $product = Product::create($body);

            if (count($sku["photo_list"])) {
                foreach ($sku["photo_list"] as $url) {
                    $product->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
                }
            }
        }
    }

    private function checkAvailabilityByStock(array $stockList): bool
    {
        $total = 0;

        foreach ($stockList as $stock) {
            if (!isset($stock['type'], $stock['value'])) {
                continue;
            }

            if ($stock['type'] === 'idp' && (int)$stock['value'] > 0) {
                return true;
            }

            if ($stock['type'] === 'total') {
                $total = (int)$stock['value'];
            }
        }

        return $total > 0;
    }

    private function buildBody(array $sku, int $categoryId, $markup): array
    {
        return [
            "name" => $sku["name"],
            "price" => $sku["price_list"][0]["value"] ?? 0,
            "brand" => $sku["brand"],
            "code" => $sku["sku"],
            "category_id" => $categoryId,
            "description" => $sku["description"],
            "manufacturer" => $sku["manufacturer"],
            "weight" => $sku["weight"],
            "volume" => $sku["volume"],
            "barcode" => $sku["barcode"] ?? null,
            "vendor_code" => $sku["vendor_code"] ?? null,
            "properties" => $sku["facet_list"] ? $this->parseProperties($sku["facet_list"]) : null,
            "integration" => "samson",
            "stock" => $this->getStock("idp", $sku["stock_list"]),
            "markup" => $markup
        ];
    }

    private function buildUrl(string $url, string $queryParams = ''): string
    {
        return sprintf(
            $this->baseUrl . '%s?api_key=%s%s',
            $url,
            $this->apiKey,
            $queryParams
        );
    }
}
