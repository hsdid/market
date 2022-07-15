<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\ReadModel;

use App\Domain\Offer\Model\OfferPhoto;
use App\Domain\Offer\ValueObject\PriceRange;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class OfferView
{
    public string $offerId;
    public string $userId;
    public string $title;
    public string $description;
    public ?string $companyId;
    public ?PriceRange $price;
    public bool $active;
    public DateTimeInterface $createdAt;
    /**
     * @var Collection<OfferPhoto>
     */
    protected Collection $photos;

    public function __construct(
        string $offerId,
        string $userId,
        string $title,
        string $description,
        ?string $companyId,
        ?PriceRange $price,
        DateTimeInterface $createdAt,
        bool $active
    ) {
        $this->offerId = $offerId;
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->companyId = $companyId;
        $this->price = $price;
        $this->createdAt = $createdAt;
        $this->active = $active;
        $this->photos = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getOfferId(): string
    {
        return $this->offerId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
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
    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    /**
     * @return PriceRange
     */
    public function getPriceRange(): ?PriceRange
    {
        return $this->price;
    }

//    /**
//     * @return Collection
//     */
//    public function getPhotos()
//    {
//        return $this->photos;
//    }

    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }



    public function serialize(): array
    {
        return  [
            'offerId' => $this->getOfferId(),
            'userId' => $this->getUserId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'companyId' => $this->getCompanyId(),
            'active' => $this->isActive(),
            'createdAt' => $this->getCreatedAt(),
            'price' => $this->getPriceRange(),
        ];
    }
}