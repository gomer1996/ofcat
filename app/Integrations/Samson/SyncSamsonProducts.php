<?php

namespace App\Integrations\Samson;

use App\Models\Category;
use App\Models\LinkedCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SyncSamsonProducts { //&pagination_page=0
    private $url = "https://api.samsonopt.ru/v1/sku/190892?api_key=60769b17043981a854f4d6ac667e5ac5&pagination_count=50";

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
                try {
                    $categoriesIds = $sku["category_list"];
                    $mainCategoryId = $categoriesIds[0] ?? null;

                    if (!$mainCategoryId) {
                        continue;
                    }

                    $category = Category::where('samson_id', $mainCategoryId)->first();

                    if (!$category || !($sku["price_list"][0]["value"] ?? null)) continue;

                    $body = $this->buildBody($sku, $category);

                    $existingProduct = Product::where(['outer_id' => $sku["sku"], 'integration' => 'samson'])->first();

                    if ($existingProduct) {
                        $existingProduct->update($body);
                    } else {
                        $existingProduct = Product::where('vendor_code', $sku["vendor_code"])
                            ->orWhere('barcode', $sku["barcode"])
                            ->first();

                        if ($existingProduct) continue;

                        $product = Product::create($body);

                        if (count($sku["photo_list"])) {
                            foreach ($sku["photo_list"] as $url) {
                                $product->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
                            }
                        }
                    }
                    $this->updateLinkedCategories($category, $categoriesIds);

                } catch (\Exception $e) {
                    Log::error('Samson product sync error msg: ' . $e->getMessage() . json_encode($sku));
                    continue;
                }
            }
        }

        if (isset($data["meta"]["pagination"]["next"])) {
            usleep( 2 * 1000 );
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

    private function getStock(string $key = '', array $stock = [])
    {
        $found = null;

        foreach($stock as $s){
            if ($s["type"] == $key) $found = $s;
        }
        if ($found && $found["value"]) {
            return $found["value"];
        }
        return 0;
    }

    private function updateLinkedCategories(Category $category, array $samsonCategoriesIds): void
    {
        // we cut the first because we assume that first category is main and others are linked categories
        array_shift($samsonCategoriesIds);
        if (!count($samsonCategoriesIds)) {
            return;
        }
        $categories = Category::whereIn('samson_id', $samsonCategoriesIds)->get();
        // we should add to LinkedCategory other categories from categoriesIds
        foreach ($samsonCategoriesIds as $id) {
            $cat = Category::where('samson_id', $id)->first();

            if (!$cat) {
                continue;
            }

            $data = [
                'category_id' => $category->getAttribute('id'),
                'linked_category_id' => $cat->getAttribute('id')
            ];
            LinkedCategory::updateOrCreate($data, $data);
        }

        $this->setCategoriesAsLinked($samsonCategoriesIds, $categories);
    }

    private function buildBody(array $sku, Category $category): array
    {
        return [
            "name" => $sku["name"],
            "outer_id" => $sku["sku"],
            "price" => $sku["price_list"][0]["value"] ?? 0,
            "brand" => $sku["brand"],
            "code" => $sku["sku"],
            "category_id" => $category->getAttribute('id'),
            "description" => $sku["description"],
            "manufacturer" => $sku["manufacturer"],
            "weight" => $sku["weight"],
            "volume" => $sku["volume"],
            "barcode" => $sku["barcode"] ?? null,
            "vendor_code" => $sku["vendor_code"] ?? null,
            "properties" => $sku["facet_list"] ? $this->parseProperties($sku["facet_list"]) : null,
            "integration" => "samson",
            "stock" => $this->getStock("idp", $sku["stock_list"])
        ];
    }

    /**
     * @param array $samsonCategoriesIds
     * @param Collection $categories
     */
    private function setCategoriesAsLinked(array $samsonCategoriesIds, Collection $categories): void
    {
        Category::whereIn('samson_id', $samsonCategoriesIds)->update([
            'is_link' => true
        ]);

        foreach ($categories as $category) {
            $this->setParentCategoriesAsLinked($category);
        }
    }

    private function setParentCategoriesAsLinked(Category $category): void
    {
        $parentCategory = Category::where([
            'id' => $category->getAttribute('parent_id'),
            'is_link' => false
        ])->first();

        if ($parentCategory) {
            $parentCategory->setAttribute('is_link', true);
            $parentCategory->save();

            if ($parentCategory->getAttribute('parent_id')) {
                $this->setParentCategoriesAsLinked($parentCategory);
            }
        }
    }
}
