<?php

namespace App\Integrations\Relef;

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
        $products = Product::withoutGlobalScopes()->where('integration', 'relef')->get();

        foreach ($products as $i => $product) {
            try {
                if (!$product->code) {
                    continue;
                }

                $relefProduct = $this->getRelefProduct($product->code);

                if (!$relefProduct) {
                    Log::info('Deleting relef product: ' . $product->code);
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

    private function getRelefProduct(string $code): ?array
    {
        $res = Http::withHeaders([
            "apikey" => "fc21beb2dc194755a1414cdcc2a7c8e5"
        ])->post($this->url, [
            "filter" => [
                "code" => $code
            ],
            "limit" => 1
        ]);

        if ($res->serverError()) {
            throw new \Exception('Server error');
        }

        $data = $res->json();

        return $data["list"][0] ?? null;
    }

    public function fetchProduct(string $code, int $categoryId, ?float $markup): void
    {
        $product = null;

        try {
            $product = $this->getRelefProduct($code);
        } catch (\Throwable $e) {

        }

        if (!$product) {
            return;
        }

        $found = Product::withoutGlobalScopes()->where(['code' => $product["code"], 'integration' => 'relef'])->first();

        $body = [
            "name" => $product["name"],
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
            "stock" => $this->getStock('Новосибирск', $product["remains"]),
            "markup" => $markup
        ];
        if ($found) {
            $found->update($body);
        } else {
            $found = Product::withoutGlobalScopes()->where('vendor_code', $product["vendorCode"])->first();

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
