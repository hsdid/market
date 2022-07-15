<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Company;

use App\Domain\Company\Company;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;

final class Get extends AbstractFOSRestController
{
    /**
     * @Route(methods={"GET"}, name="api.company.get", path="/api/company/{company}")
     */
    public function __invoke(Company $company): View
    {
        return $this->view($company);
    }
}
