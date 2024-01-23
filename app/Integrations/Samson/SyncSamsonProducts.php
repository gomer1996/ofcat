<?php

namespace App\Integrations\Samson;

use App\Models\Category;
use App\Models\LinkedCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
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
        $products = Product::where('integration', 'samson')->get();

        /**
         * @var Product $product
         */
        foreach ($products as $i => $product) {
            try {
                if (!$product->outer_id) {
                    return;
                }

                $skuData = $this->getSamsonProduct($product->outer_id);

                if (!$skuData) {
                    Log::info('Deleting samson product: ' . $product->outer_id);
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

                if ($stock == 0) {
                    $product->is_active = 0;
                }

                $product->save();
            } catch (\Exception $E) {

            }
            usleep(1000);
        }
    }

    public function fetchSku(string $sku, int $categoryId): void
    {
        $skuData = null;

        try {
            $skuData = $this->getSamsonProduct($sku);
        } catch (\Throwable $e) {

        }

        if (!$skuData) {
            return;
        }

        $this->createOrUpdateProduct($skuData, $categoryId);
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

    private function createOrUpdateProduct(array $sku, int $categoryId): void
    {
        $body = $this->buildBody($sku, $categoryId);

        $existingProduct = Product::where(['outer_id' => $sku["sku"], 'integration' => 'samson'])->first();

        if ($existingProduct) {
            $existingProduct->update($body);
        } else {
            $existingProduct = Product::where('vendor_code', $sku["vendor_code"])
                ->orWhere('barcode', $sku["barcode"])
                ->first();

            if ($existingProduct) {
                return;
            }

            $product = Product::create($body);

            if (count($sku["photo_list"])) {
                foreach ($sku["photo_list"] as $url) {
                    $product->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
                }
            }
        }
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

    private function buildBody(array $sku, int $categoryId): array
    {
        return [
            "name" => $sku["name"],
            "outer_id" => $sku["sku"],
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
