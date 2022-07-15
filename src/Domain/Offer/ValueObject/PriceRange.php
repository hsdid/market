<?php
declare(strict_types=1);

namespace App\Domain\Offer\ValueObject;

class PriceRange
{
    protected float $minPrice;
    protected float $maxPrice;

    public function __construct(float $minPrice, float $maxPrice)
    {
        $this->minPrice = $minPrice;
        $this->maxPrice = $maxPrice;
    }

    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    public function getMaxPrice(): float
    {
        return $this->maxPrice;
    }

    public function toArray(): array
    {
        return [
            'minPrice' => $this->getMinPrice(),
            'maxPrice' => $this->getMaxPrice()
        ];
    }
}
