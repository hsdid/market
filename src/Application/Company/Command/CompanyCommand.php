<?php
declare(strict_types=1);
namespace App\Application\Company\Command;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Message\Command;

abstract class CompanyCommand implements Command
{
    protected CompanyId $companyId;

    public function __construct(CompanyId $companyId)
    {
        $this->companyId = $companyId;
    }

    public function getCompanyId(): CompanyId
    {
        return $this->companyId;
    }
}
