<?php
declare(strict_types=1);
namespace App\Application\Offer\Command;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Id\UserId;
use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use DateTimeInterface;

class CreateOfferCommand extends OfferCommand
{
    protected OfferId $offerId;
    protected UserId $userId;
    protected string $title;
    protected string $description;
    protected ?CompanyId $companyId;
    protected PriceRange $price;
    protected Address $address;
    protected bool $active = true;
    protected DateTimeInterface $createdAt;

    public function __construct(
        OfferId $offerId,
        UserId $userId,
        string $title,
        string $description,
        ?CompanyId $companyId,
        PriceRange $price,
        Address $address,
        bool $active,
        DateTimeInterface $createdAt
    ) {
        parent::__construct($offerId);
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->companyId = $companyId;
        $this->price = $price;
        $this->address = $address;
        $this->active = $active;
        $this->createdAt = $createdAt;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }

    public function getPriceRange(): PriceRange
    {
        return $this->price;
    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return Address
     */
    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getCompanyId(): ?CompanyId
    {
        return $this->companyId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
