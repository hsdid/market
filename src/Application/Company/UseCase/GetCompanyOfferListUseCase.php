<?php
declare(strict_types=1);

namespace App\Application\Company\UseCase;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Offer\ReadModel\ReadOfferRepositoryInterface;

class GetCompanyOfferListUseCase
{
    private ReadOfferRepositoryInterface $offerRepository;

    public function __construct(ReadOfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function execute(CompanyId $companyId): array
    {
        return $this->offerRepository->getCompanyOffers($companyId);
    }
}
