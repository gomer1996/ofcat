<?php

namespace App\Integrations\Relef\DTO;

final class RelefProductDTO
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
    private ?string $vendorCode;
    private ?array $properties;
    private ?string $integration;
    private ?int $stock;
    private ?float $markup;
    private ?int $totalStock;
    private array $images;

    public function __construct(array $product, ?int $categoryId = null, $markup = null)
    {
        $this->name = $product['name'];
        $this->price = $this->getPreferredPrice($product['prices']);
        $this->brand = $product['brand']['name'] ?? null;
        $this->code = $product['code'];
        $this->categoryId = $categoryId;
        $this->description = $product['description'] ?? null;
        $this->manufacturer = $product['manufacturer']['name'] ?? null;
        $this->weight = $product['weight'] ?? 0;
        $this->volume = $product['volume'] ?? 0;
        $this->vendorCode = $product['vendorCode'] ?? null;
        $this->properties = !empty($product['properties'])
            ? $this->parseProperties($product['properties'])
            : null;
        $this->integration = 'relef';
        $this->stock = $this->parseStock('Новосибирск', $product['remains']);
        $this->totalStock = $this->parseStock('Рязань', $product['remains']);
        $this->markup = $markup;

        $images = [];
        foreach ($product["images"] as $img) {
            $images[] = $img["path"];
        }

        $this->images = $images;
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

    public function getCode(): string
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

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function getVolume(): float
    {
        return $this->volume;
    }

    public function getVendorCode(): ?string
    {
        return $this->vendorCode;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
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

    public function getImages(): array
    {
        return $this->images;
    }

    public function isActive(): bool
    {
        return (bool) $this->getStock() + $this->getTotalStock();
    }

    private function getPreferredPrice(array $prices): float
    {
        $recommend = 0.0;

        foreach ($prices as $price) {
            if (!isset($price['type'], $price['value'])) {
                continue;
            }

            if ($price['type'] === 'contracts' && is_numeric($price['value'])) {
                return (float) $price['value'];
            }

            if ($price['type'] === 'recommend' && is_numeric($price['value'])) {
                $recommend = (float) $price['value'];
            }
        }

        return $recommend;
    }

    public function parseProperties(array $props): array
    {
        $properties = [];

        foreach ($props as $prop) {
            $properties[$prop["name"]] = $prop["value"];
        }

        return $properties;
    }

    private function parseStock(string $key = '', array $stock = [])
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
