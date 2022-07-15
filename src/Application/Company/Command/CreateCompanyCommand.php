<?php
declare(strict_types=1);
namespace App\Application\Company\Command;

use App\Domain\Company\ValueObject\Address;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\UserId;

class CreateCompanyCommand extends CompanyCommand
{
    protected UserId $userId;
    protected string $name;
    protected string $description;
    protected ?Address $address;
    protected bool $active = true;

    public function __construct(
        CompanyId $companyId,
        UserId $userId,
        string $name,
        string $description,
        ?Address $address,
        bool $active
    ) {
        parent::__construct($companyId);
        $this->userId = $userId;
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->active = $active;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
