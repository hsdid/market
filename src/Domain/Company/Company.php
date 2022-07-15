<?php
declare(strict_types=1);

namespace App\Domain\Company;

use App\Domain\Company\Model\CompanyPhoto;
use App\Domain\Company\ValueObject\Address;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\UserId;
use App\Domain\Offer\Offer;
use App\Domain\User\UserInterface;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Company implements \JsonSerializable
{
    protected CompanyId $companyId;
    protected UserInterface $user;
    protected string $name;
    protected string $description;
    protected Address $address;
    protected DateTimeInterface $createdAt;
    protected bool $active;
    /**
     * @var Collection<CompanyPhoto>
     */
    protected Collection $photos;
    /**
     * @var Collection<Offer>
     */
    protected Collection $offers;

    public function __construct(
        CompanyId $companyId,
        UserInterface $user,
        string $name,
        string $description,
        Address $address,
        bool $active
    ) {
        $this->companyId = $companyId;
        $this->user = $user;
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->active = $active;
        $this->createdAt = new DateTime('now');
        $this->photos = new ArrayCollection();
        $this->offers = new ArrayCollection();
    }

    public function getCompanyId(): CompanyId
    {
        return $this->companyId;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     */
    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     */
    public function setAddress(Address $address): void
    {
        $this->address = $address;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getPhotos()
    {
        return $this->photos;
    }

    public function jsonSerialize(): array
    {
        return  [
            'companyId' => (string) $this->getCompanyId(),
            'userId' => (string) $this->getUser()->getId(),
            'name' => $this->getName(),
            'active' => $this->isActive(),
            'description' => $this->getDescription(),
            'address' => $this->getAddress(),
            'createdAt' => $this->getCreatedAt(),
            'photos' => $this->getPhotos()
        ];
    }
}
