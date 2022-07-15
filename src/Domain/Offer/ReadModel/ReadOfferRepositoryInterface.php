<?php

namespace App\Domain\Offer\ReadModel;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Search\SearchableInterface;

interface ReadOfferRepositoryInterface extends SearchableInterface
{
    public function getAllOffers(): array;

    public function getCompanyOffers(CompanyId $companyId): array;
}
