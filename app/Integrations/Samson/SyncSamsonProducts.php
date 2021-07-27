<?php

namespace App\Integrations\Samson;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Http;


class SyncSamsonProducts {
    private $url = "https://api.samsonopt.ru/v1/sku/190892?api_key=60769b17043981a854f4d6ac667e5ac5&pagination_count=10";

    public function __invoke()
    {
        $this->syncProducts($this->url);
    }

    private function syncProducts(string $url)
    {
        $res = Http::get($url);
        $data = $res->json();

        if ($data) {
            foreach ($data["data"] as $sku) {
                $found = Product::where(['outer_id' => $sku["sku"], 'integration' => 'samson'])->first();

                $category = Category::whereIn('samson_id', $sku["category_list"])->orderBy('level', 'desc')->first();

                if (!$category || !$sku["price_list"][0]["value"]) continue;

                $body = [
                    "name" => $sku["name"],
                    "outer_id" => $sku["sku"],
                    "price" => $sku["price_list"][0]["value"] || 0,
                    "brand" => $sku["brand"],
                    "code" => $sku["sku"],
                    "category_id" => $category->id,
                    "description" => $sku["description"],
                    "manufacturer" => $sku["manufacturer"],
                    "weight" => $sku["weight"],
                    "volume" => $sku["volume"],
                    "barcode" => $sku["barcode"] ? $sku["barcode"] : null,
                    "vendor_code" => $sku["vendor_code"] ? $sku["vendor_code"] : null,
                    "properties" => $sku["facet_list"] ? $this->parseProperties($sku["facet_list"]) : null,
                    "integration" => "samson"
                ];
                if ($found) {
                    $found->update($body);
                } else {
                    $product = Product::create($body);

                    if (count($sku["photo_list"])) {
                        foreach ($sku["photo_list"] as $url) {
                            $product->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
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
