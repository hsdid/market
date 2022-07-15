<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Company;

use App\Application\Company\UseCase\GetListCompanyUseCase;
use App\Infrastructure\Company\Form\CompanySearchType;
use App\Infrastructure\Core\Form\Search\Symfony\SearchFormFactoryInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetList extends AbstractFOSRestController
{
    private GetListCompanyUseCase $useCase;
    private SearchFormFactoryInterface $searchFormFactory;

    public function __construct(
        GetListCompanyUseCase $useCase,
        SearchFormFactoryInterface $searchFormFactory
    ) {
        $this->useCase = $useCase;
        $this->searchFormFactory = $searchFormFactory;
    }

    /**
     * @Route(methods={"GET"}, name="api.company.getList", path="/api/company")
     * @OA\Get(
     *     path="/api/company",
     *     tags={"Company"},
     *     operationId="companyGetList",
     *     summary="Get company list",
     *     @OA\Response(
     *         response="200",
     *         description="Company List",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *              )
     *         )
     *      )
     * )
     */
    public function __invoke(Request $request): View
    {
        $form = $this->searchFormFactory->createAndHandle(
            CompanySearchType::class,
            $request->request->all()
        );

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $result = $this->useCase->execute($form->getData());

        return $this->view($result, Response::HTTP_OK);
    }
}
