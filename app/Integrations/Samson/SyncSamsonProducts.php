<?php

namespace App\Integrations\Samson;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Http;


class SyncSamsonProducts {

    public function __invoke()
    {
        $this->syncProducts("https://api.samsonopt.ru/v1/sku/190892?api_key=60769b17043981a854f4d6ac667e5ac5&pagination_count=10&pagination_page=3328");
    }

    private function syncProducts(string $url)
    {
        $res = Http::get($url);
        $data = $res->json();

        if ($data) {
            foreach ($data["data"] as $sku) {
                $found = Product::where(['samson_sku' => $sku["sku"]])->first();
                //$categories = Category::whereIn('samson_id', $sku["category_list"])->get('id'); todo del
                $category = Category::whereIn('samson_id', $sku["category_list"])->orderBy('level', 'desc')->first();
                if (!$category) continue;
                $body = [
                    "name" => $sku["name"],
                    "samson_sku" => $sku["sku"],
                    "price" => $sku["price_list"][0]["value"], // todo price
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
                ];
                if ($found) {
                    $found->update($body);
                    //if ($categories->count()) $found->categories()->sync($categories->pluck('id')); todo del
                } else {
                    $product = Product::create($body);

                    //if ($categories->count()) $product->categories()->sync($categories->pluck('id')); todo del
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
