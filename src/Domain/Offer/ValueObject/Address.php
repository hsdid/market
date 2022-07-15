<?php
declare(strict_types=1);

namespace App\Domain\Offer\ValueObject;

use phpDocumentor\Reflection\Types\This;

class Address
{
    protected ?string $province;
    protected ?string $city;
    protected ?string $address;
    protected ?string $street;
    protected ?string $postal;

    public function __construct(
        ?string $province,
        ?string $city,
        ?string $address,
        ?string $street,
        ?string $postal
    ) {
        $this->province = $province;
        $this->city = $city;
        $this->address = $address;
        $this->street = $street;
        $this->postal = $postal;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function getPostal(): ?string
    {
        return $this->postal;
    }

    public function toArray(): array
    {
        return [
            'province' => $this->getProvince(),
            'city' => $this->getCity(),
            'address' => $this->getAddress(),
            'street' => $this->getStreet(),
            'postal' => $this->getPostal(),
        ];
    }
}
