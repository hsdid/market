<?php
declare(strict_types=1);

namespace App\Domain\Company;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Search\SearchableInterface;

interface CompanyRepositoryInterface extends SearchableInterface
{
    public function save(Company $company): void;

    public function getById(CompanyId $id): ?Company;

    public function getByName(string $name): ?Company;
}
