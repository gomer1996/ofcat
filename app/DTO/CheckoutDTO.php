<?php

namespace App\DTO;

class CheckoutDTO
{
    /** @var string */
    private $name;

    /** @var string|null */
    private $company;

    /** @var string */
    private $email;

    /** @var string */
    private $phone;

    /** @var string|null */
    private $address;

    /** @var string|null */
    private $note;

    /** @var string */
    private $delivery;

    /** @var string */
    private $userType;

    private $price;

    public function __construct(
        string $name,
        ?string $company,
        string $email,
        string $phone,
        ?string $address,
        ?string $note,
        string $delivery,
        string $userType,
        float $price
    ) {
        $this->name = $name;
        $this->company = $company;
        $this->email = $email;
        $this->phone = $phone;
        $this->address = $address;
        $this->note = $note;
        $this->delivery = $delivery;
        $this->userType = $userType;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function getDelivery(): ?string
    {
        if ($this->delivery === 'delivery') {
            return 'Доставка';
        }

        if ($this->delivery === 'pickup') {
            return 'Самовывоз';
        }

        return null;
    }

    public function getUserType(): string
    {
        return $this->userType === 'person' ? 'Физ лицо' : 'Юр лицо';
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}
