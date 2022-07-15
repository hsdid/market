<?php
declare(strict_types=1);

namespace App\Domain\Offer;

use App\Domain\Company\Company;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Id\UserId;
use App\Domain\Offer\Model\OfferPhoto;
use App\Domain\Offer\ValueObject\Address;
use App\Domain\Offer\ValueObject\PriceRange;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Offer implements \JsonSerializable
{
    protected OfferId $offerId;
    protected UserId $userId;
    protected string $title;
    protected string $description;
    protected ?Company $company;
    protected PriceRange $price;
    protected Address $address;
    protected bool $active;
    protected DateTimeInterface $createdAt;
    /**
     * @var Collection<OfferPhoto>
     */
    protected Collection $photos;

    public function __construct(
        OfferId $offerId,
        UserId $userId,
        string $title,
        string $description,
        ?Company $company,
        PriceRange $price,
        Address $address,
        DateTimeInterface $createdAt,
        bool $active
    ) {
        $this->offerId = $offerId;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->company = $company;
        $this->price = $price;
        $this->address = $address;
        $this->createdAt = $createdAt;
        $this->active = $active;
        $this->photos = new ArrayCollection();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getOfferId(): OfferId
    {
        return $this->offerId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function getPriceRange(): PriceRange
    {
        return $this->price;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setCompany(?Company $company): void
    {
        $this->company = $company;
    }

    public function setPriceRange(PriceRange $price): void
    {
        $this->price = $price;
    }

    public function deactivate(): void
    {
        $this->active = false;
    }


    public function activate(): void
    {
        $this->active = true;
    }

    public function getPhotos(): array
    {
        return $this->photos->toArray();
    }

    public function jsonSerialize(): array
    {
        return  [
            'offerId' => (string) $this->getOfferId(),
            'userId' => (string) $this->getUserId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'companyId' => $this->getCompany() ? (string) $this->getCompany()->getCompanyId() : null,
            'active' => $this->isActive(),
            'address' => $this->getAddress(),
            'createdAt' => $this->getCreatedAt(),
            'price' => $this->getPriceRange(),
            'photos' => $this->getPhotos()
        ];
    }
}
