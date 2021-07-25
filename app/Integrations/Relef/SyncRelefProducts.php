<?php

namespace App\Integrations\Relef;

use App\Models\IntegrationCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class SyncRelefProducts
{
    private $url = "https://api-sale.relef.ru/api/v1/products/list";

    public function __invoke()
    {
        $this->syncProducts($this->url);
    }

    private function syncProducts(string $url)
    {
        $res = Http::withHeaders([
            "apikey" => "f9f84dcf7bd647389500dc3ee23d6a25"
        ])->post($url, [
            "limit" => 10
        ]);

        $data = $res->json();

        if ($data) {
            foreach ($data["list"] as $product) {
                $category = IntegrationCategory::where('integration', 'relef')
                    ->whereIn('outer_id', $product["sections"])
                    ->orderBy('level', 'desc')
                    ->first();

                if (!$category) continue;

                $found = Product::where(['outer_id' => $product["guid"], 'integration' => 'relef'])->first();

                $body = [
                    "name" => $product["name"],
                    "outer_id" => $product["guid"],
                    "price" => $product["prices"][0]["value"] || 0, // todo price
                    "brand" => $product["brand"]["name"],
                    //"code" => $product["code"], todo conflicts with samson sku
                    "integration_category_id" => $category->id,
                    "description" => $product["description"],
                    "manufacturer" => $product["manufacturer"]["name"],
//                    "weight" => $product["weight"], todo see
//                    "volume" => $product["volume"],
                    "vendor_code" => $product["vendorCode"] ? $product["vendorCode"] : null,
                    "properties" => $product["properties"] ? $this->parseProperties($product["properties"]) : null,
                    "integration" => "relef"
                ];
                if ($found) {
                    $found->update($body);
                } else {
                    $newProduct = Product::create($body);

                    if (count($product["images"])) {
                        foreach ($product["images"] as $img) {
                            $newProduct->addMediaFromUrl($img["path"])->toMediaCollection('product_media_collection');
                        }
                    }
                }
            }
        }

        if (isset($data["meta"]["pagination"]["next"])) {
            $this->syncProducts($data["meta"]["pagination"]["next"]);
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
}
