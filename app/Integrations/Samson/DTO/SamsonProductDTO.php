<?php

namespace App\Integrations\Samson\DTO;

final class SamsonProductDTO
{
    private ?string $name;
    private ?float $price;
    private ?string $brand;
    private ?string $code;
    private ?int $categoryId;
    private ?string $description;
    private ?string $manufacturer;
    private ?float $weight;
    private ?float $volume;
    private ?string $barcode;
    private ?string $vendorCode;
    private ?array $properties;
    private ?array $photoList;
    private ?string $integration;
    private ?int $stock;
    private ?int $totalStock;
    private ?int $markup;

    public function __construct(array $sku, ?int $categoryId = null, ?float $markup = null)
    {
        $this->name = $sku['name'];
        $this->price = $sku['price_list'][0]['value'] ?? 0;
        $this->brand = $sku['brand'];
        $this->code = $sku['sku'];
        $this->categoryId = $categoryId;
        $this->description = $sku['description'];
        $this->manufacturer = $sku['manufacturer'];
        $this->weight = $sku['weight'];
        $this->volume = $sku['volume'];
        $this->barcode = $sku['barcode'] ?? null;
        $this->vendorCode = $sku['vendor_code'] ?? null;
        $this->properties = !empty($sku['facet_list'])
            ? $this->parseProperties($sku['facet_list'])
            : null;
        $this->integration = 'samson';
        $this->stock = $this->parseStock("idp", $sku['stock_list']);
        $this->totalStock = $this->parseStock("total", $sku['stock_list']);
        $this->markup = $markup;
        $this->photoList = $sku['photo_list'] ?? [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function getVolume(): ?float
    {
        return $this->volume;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function getVendorCode(): ?string
    {
        return $this->vendorCode;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function getPhotoList(): array
    {
        return $this->photoList;
    }

    public function getIntegration(): string
    {
        return $this->integration;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getTotalStock(): int
    {
        return $this->totalStock;
    }

    public function getMarkup(): ?float
    {
        return $this->markup;
    }

    public function isActive(): bool
    {
        return (bool) $this->getStock() + $this->getTotalStock();
    }

    private function parseProperties(array $props): array
    {
        $properties = [];

        foreach ($props as $prop) {
            $properties[$prop["name"]] = $prop["value"];
        }

        return $properties;
    }

    private function parseStock(string $key = '', array $stockList = []): int
    {
        foreach ($stockList as $stock) {
            if ($stock["type"] == $key) {
                return (int) $stock["value"];
            }
        }

        return 0;
    }
}

