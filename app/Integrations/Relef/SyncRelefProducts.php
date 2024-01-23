<?php

namespace App\Integrations\Relef;

use App\Models\IntegrationCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncRelefProducts
{
    private $url = "https://api-sale.relef.ru/api/v1/products/list";
    private $offset = 0;


    public function __invoke()
    {
        $this->syncProducts();
    }

    private function syncProducts(): void
    {
        $products = Product::where('integration', 'relef')->get();

        foreach ($products as $i => $product) {
            try {
                if (!$product->outer_id) {
                    return;
                }

                $relefProduct = $this->getRelefProduct($product->outer_id);

                if (!$relefProduct) {
                    Log::info('Deleting relef product: ' . $product->outer_id);
                    $product->delete();
                    continue;
                }

                $stock = $this->getStock('Новосибирск', $relefProduct["remains"]);
                $price = $relefProduct["prices"][0]["value"] ?? 0;

                if ($price <= 0) {
                    continue;
                }

                $product->price = $price;
                $product->stock = $stock;

                if ($stock == 0) {
                    $product->is_active = 0;
                }

                $product->save();
            } catch (\Exception $E) {
                // do nothing
            }
            usleep(1000);
        }
    }

    private function getRelefProduct(string $guid): ?array
    {
        $res = Http::withHeaders([
            "apikey" => "f9f84dcf7bd647389500dc3ee23d6a25"
        ])->post($this->url, [
            "filter" => [
                "guid" => $guid
            ],
            "limit" => 1
        ]);

        if ($res->serverError()) {
            throw new \Exception('Server error');
        }

        $data = $res->json();

        return $data["list"][0] ?? null;
    }

    public function fetchProduct(string $guid, int $categoryId): void
    {
        $product = null;

        try {
            $product = $this->getRelefProduct($guid);
        } catch (\Throwable $e) {

        }

        if (!$product) {
            return;
        }

        $found = Product::where(['outer_id' => $product["guid"], 'integration' => 'relef'])->first();

        $body = [
            "name" => $product["name"],
            "outer_id" => $product["guid"],
            "price" => $product["prices"][0]["value"] ?? 0,
            "brand" => $product["brand"]["name"] ?? null,
            "code" => $product["code"],
            "category_id" => $categoryId,
            "description" => $product["description"] ?? null,
            "manufacturer" => $product["manufacturer"]["name"] ?? null,
            "weight" => $product["weight"] ?? 0,
            "volume" => $product["volume"] ?? 0,
            "vendor_code" => $product["vendorCode"] ?? null,
            "properties" => $product["properties"] ? $this->parseProperties($product["properties"]) : null,
            "integration" => "relef",
            "stock" => $this->getStock('Новосибирск', $product["remains"])
        ];
        if ($found) {
            $found->update($body);
        } else {
            $found = Product::where('vendor_code', $product["vendorCode"])->first();

            if ($found) return;

            $newProduct = Product::create($body);

            if (count($product["images"])) {
                foreach ($product["images"] as $img) {
                    $newProduct->addMediaFromUrl($img["path"])->toMediaCollection('product_media_collection');
                }
            }
        }
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

        foreach($stock as $s){
            if (isset($s["store"]) && $s["store"] == $key) $found = $s;
        }
        if ($found && isset($found["quantity"])) {
            return $found["quantity"];
        }
        return 0;
    }
}
