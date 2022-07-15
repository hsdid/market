<?php

namespace App\Ui\Rest\Controller\Company;

use App\Application\Company\UseCase\GetCompanyOfferListUseCase;
use App\Domain\Company\Company;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Route;
use OpenApi\Annotations as OA;

final class GetCompanyOffers extends AbstractFOSRestController
{
    private GetCompanyOfferListUseCase $useCase;

    public function __construct(GetCompanyOfferListUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"GET"}, name="api.company.get.offers.list", path="/api/company/{company}/offer")
     */
    public function __invoke(Company $company): View
    {
        $result = $this->useCase->execute($company->getCompanyId());
        return $this->view(['total' => count($result), 'offer' => $result]);
    }
}
