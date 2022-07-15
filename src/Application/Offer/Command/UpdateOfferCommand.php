<?php
declare(strict_types=1);

namespace App\Application\Offer\Command;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\OfferId;
use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;

class UpdateOfferCommand extends OfferCommand
{
    protected string $title;
    protected string $description;
    protected ?CompanyId $companyId;
    protected PriceRange $price;
    protected Address $address;
    protected bool $active;

    public function __construct(
        OfferId $offerId,
        string $title,
        string $description,
        ?CompanyId $companyId,
        PriceRange $price,
        Address $address,
        bool $active
    ) {
        parent::__construct($offerId);
        $this->title = $title;
        $this->description = $description;
        $this->companyId = $companyId;
        $this->price = $price;
        $this->address = $address;
        $this->active = $active;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCompanyId(): ?CompanyId
    {
        return $this->companyId;
    }

    public function getPriceRange(): PriceRange
    {
        return $this->price;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }
}
