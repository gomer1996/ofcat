<?php

namespace App\Integrations\Relef;

use App\Integrations\Relef\DTO\RelefProductDTO;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncRelefProducts
{
    private $url = "https://api-sale.relef.ru/api/v1/products/list";

    public function __invoke()
    {
        $this->syncProducts();
    }

    private function syncProducts(): void
    {
        $products = Product::withoutGlobalScopes()->where('integration', 'relef')->get();

        foreach ($products as $product) {
            try {
                if (!$product->code) {
                    continue;
                }

                $relefProductDTO = $this->fetchRelefProduct($product->code);

                if (!$relefProductDTO) {
                    Log::info('Deleting relef product: ' . $product->code);
                    $product->delete();
                    continue;
                }

                if ($relefProductDTO->getPrice() <= 0) {
                    continue;
                }

                $product->price = $relefProductDTO->getPrice();
                $product->stock = $relefProductDTO->getStock();
                $product->total_stock = $relefProductDTO->getTotalStock();
                $product->is_active = $relefProductDTO->isActive();

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

    public function fetchRelefProduct(string $code, ?int $categoryId = null, ?float $markup = null): ?RelefProductDTO
    {
        $data = $this->getRelefProduct($code);

        if (!$data) {
            return null;
        }

        return new RelefProductDTO($data, $categoryId, $markup);
    }

    public function fetchProduct(string $code, int $categoryId, ?float $markup): void
    {
        $relefProductDTO = null;

        try {
            $relefProductDTO = $this->fetchRelefProduct($code, $categoryId, $markup);
        } catch (\Throwable $e) {

        }

        if (!$relefProductDTO) {
            return;
        }

        $found = Product::withoutGlobalScopes()->where(['code' => $relefProductDTO->getCode(), 'integration' => 'relef'])->first();

        $body = $this->buildBody($relefProductDTO);

        if ($found) {
            $found->update($body);
        } else {
            $found = Product::withoutGlobalScopes()->where('vendor_code', $relefProductDTO->getVendorCode())->first();

            if ($found) return;

            $newProduct = Product::create($body);

            if (count($relefProductDTO->getImages())) {
                foreach ($relefProductDTO->getImages() as $url) {
                    $newProduct->addMediaFromUrl($url)->toMediaCollection('product_media_collection');
                }
            }
        }
    }

    private function buildBody(RelefProductDTO $relefProductDTO): array
    {
        return [
            "name" => $relefProductDTO->getName(),
            "price" => $relefProductDTO->getPrice(),
            "brand" => $relefProductDTO->getBrand(),
            "code" => $relefProductDTO->getCode(),
            "category_id" => $relefProductDTO->getCategoryId(),
            "description" => $relefProductDTO->getDescription(),
            "manufacturer" => $relefProductDTO->getManufacturer(),
            "weight" => $relefProductDTO->getWeight(),
            "volume" => $relefProductDTO->getVolume(),
            "vendor_code" => $relefProductDTO->getVendorCode(),
            "properties" => $relefProductDTO->getProperties(),
            "integration" => "relef",
            "stock" => $relefProductDTO->getStock(),
            "total_stock" => $relefProductDTO->getTotalStock(),
            "markup" => $relefProductDTO->getMarkup(),
            "is_active" => $relefProductDTO->isActive(),
        ];
    }
}
