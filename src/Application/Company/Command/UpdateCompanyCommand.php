<?php
declare(strict_types=1);

namespace App\Application\Company\Command;

use App\Domain\Company\ValueObject\Address;
use App\Domain\Core\Id\CompanyId;

class UpdateCompanyCommand extends CompanyCommand
{
    protected string $name;
    protected string $description;
    protected ?Address $address;
    protected bool $active = true;

    public function __construct(
        CompanyId $companyId,
        string $name,
        string $description,
        ?Address $address,
        bool $active
    ) {
        parent::__construct($companyId);
        $this->name = $name;
        $this->description = $description;
        $this->address = $address;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }
}
