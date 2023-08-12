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
        $this->syncProducts($this->url);
    }

    private function syncProducts(string $url)
    {
        $res = Http::withHeaders([
            "apikey" => "f9f84dcf7bd647389500dc3ee23d6a25"
        ])->post($url, [
            "limit" => 5,
            "offset" => $this->offset
        ]);

        $data = $res->json();

        if ($data) {
            foreach ($data["list"] as $product) {
                try {
                    $category = IntegrationCategory::where('integration', 'relef')
                        ->whereIn('outer_id', $product["sections"] ?? [])
                        ->orderBy('level', 'desc')
                        ->first();

                    if (!$category || !($product["prices"][2]["value"] ?? null)) continue;

                    $found = Product::where(['outer_id' => $product["guid"], 'integration' => 'relef'])->first();

                    $body = [
                        "name" => $product["name"],
                        "outer_id" => $product["guid"],
                        "price" => $product["prices"][2]["value"] ?? 0,
                        "brand" => $product["brand"]["name"] ?? null,
                        "code" => $product["code"],
                        "integration_category_id" => $category->id,
                        "description" => $product["description"],
                        "manufacturer" => $product["manufacturer"]["name"] ?? null,
                        "weight" => $product["weight"],
                        "volume" => $product["volume"],
                        "vendor_code" => $product["vendorCode"] ?? null,
                        "properties" => $product["properties"] ? $this->parseProperties($product["properties"]) : null,
                        "integration" => "relef",
                        "stock" => $this->getStock('Новосибирск', $product["remains"])
                    ];
                    if ($found) {
                        $found->update($body);
                    } else {
                        $found = Product::where('vendor_code', $product["vendorCode"])->first();

                        if ($found) continue;

                        $newProduct = Product::create($body);

                        if (count($product["images"])) {
                            foreach ($product["images"] as $img) {
                                $newProduct->addMediaFromUrl($img["path"])->toMediaCollection('product_media_collection');
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Relef product sync error msg: ' . $e->getMessage() . serialize($product));
                    continue;
                }
            }
            $this->offset = $this->offset + count($data["list"]);

            if ($data["count"] > $this->offset) {
                $this->syncProducts($this->url);
            }
            $this->offset = 0;
        }
    }

    public function fetchProduct(string $guid, int $categoryId): void
    {
        $res = Http::withHeaders([
            "apikey" => "f9f84dcf7bd647389500dc3ee23d6a25"
        ])->post($this->url, [
            "filter" => [
              "guid" => $guid
            ],
            "limit" => 1
        ]);

        $data = $res->json();

        $product = $data["list"][0] ?? null;

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
