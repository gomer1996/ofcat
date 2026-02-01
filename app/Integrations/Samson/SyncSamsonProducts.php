<?php

namespace App\Integrations\Samson;

use App\Integrations\Samson\DTO\SamsonProductDTO;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SyncSamsonProducts
{
    private string $baseUrl = "https://api.samsonopt.ru/";
    private string $apiKey = "e6f2f9ce0d1bfe7ed8a1fd8658921470";

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
        foreach ($products as $product) {
            try {
                if (!$product->code) {
                    continue;
                }

                $samsonProductDTO = $this->fetchSamsonProduct($product->code);

                if (!$samsonProductDTO) {
                    Log::info('Deleting samson product: ' . $product->code);
                    $product->delete();
                    continue;
                }

                if ($samsonProductDTO->getPrice() <= 0) {
                    continue;
                }

                $product->price = $samsonProductDTO->getPrice();
                $product->stock = $samsonProductDTO->getStock();
                $product->total_stock = $samsonProductDTO->getTotalStock();
                $product->is_active = $samsonProductDTO->isActive();

                $product->save();
            } catch (\Exception $E) {

            }
            usleep(1000);
        }
    }

    public function fetchSku(string $sku, int $categoryId, ?float $markup): void
    {
        $samsonProductDTO = null;

        try {
            $samsonProductDTO = $this->fetchSamsonProduct($sku, $categoryId, $markup);
        } catch (\Throwable $e) {

        }

        if (!$samsonProductDTO) {
            return;
        }

        $this->createOrUpdateProduct($samsonProductDTO);
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

    private function fetchSamsonProduct(string $skuCode, ?int $categoryId = null, ?int $markup = null): ?SamsonProductDTO
    {
        $samsonSku = $this->getSamsonProduct($skuCode);

        if (!$samsonSku) {
            return null;
        }

        return new SamsonProductDTO($samsonSku, $categoryId, $markup);
    }

    private function createOrUpdateProduct(SamsonProductDTO $samsonProductDTO): void
    {
        $body = $this->buildBody($samsonProductDTO);

        $existingProduct = Product::withoutGlobalScopes()->where(['code' => $samsonProductDTO->getCode(), 'integration' => 'samson'])->first();

        if ($existingProduct) {
            $existingProduct->update($body);
        } else {
            $product = Product::create($body);

            if (count($samsonProductDTO->getPhotoList())) {
                foreach ($samsonProductDTO->getPhotoList() as $url) {
                    $product->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
                }
            }
        }
    }

    /**
     * @todo move to Product class and create method like fillFromDTO
     */
    private function buildBody(SamsonProductDTO $samsonProductDTO): array
    {
        return [
            "name" => $samsonProductDTO->getName(),
            "price" => $samsonProductDTO->getPrice(),
            "brand" => $samsonProductDTO->getBrand(),
            "code" => $samsonProductDTO->getCode(),
            "category_id" => $samsonProductDTO->getCategoryId(),
            "description" => $samsonProductDTO->getDescription(),
            "manufacturer" => $samsonProductDTO->getManufacturer(),
            "weight" => $samsonProductDTO->getWeight(),
            "volume" => $samsonProductDTO->getVolume(),
            "barcode" => $samsonProductDTO->getBarcode(),
            "vendor_code" => $samsonProductDTO->getVendorCode(),
            "properties" => $samsonProductDTO->getProperties(),
            "integration" => "samson",
            "stock" => $samsonProductDTO->getStock(),
            "total_stock" => $samsonProductDTO->getTotalStock(),
            "markup" => $samsonProductDTO->getMarkup(),
            "is_active" => $samsonProductDTO->isActive(),
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
