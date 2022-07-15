<?php
declare(strict_types=1);
namespace App\Domain\Core\Id;

use App\Domain\Core\Model\Identifier;
use Assert\Assertion as Assert;
use Assert\AssertionFailedException;

class CompanyId implements Identifier
{
    protected string $companyId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $companyId)
    {
        Assert::uuid($companyId);
        $this->companyId = $companyId;
    }

    public function __toString(): string
    {
        return $this->companyId;
    }
}
