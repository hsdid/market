<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Company;

use App\Application\Company\UseCase\CreateCompanyUseCase;
use App\Infrastructure\Company\Form\CompanyFromType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;

final class Post extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private CreateCompanyUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        CreateCompanyUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.company.create", path="/api/company")
     * @OA\Post(
     *     path="/api/company",
     *     tags={"Company"},
     *     description="Create company",
     *     operationId="companyCreate",
     *     summary="Create company",
     *     @OA\RequestBody(
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="company name"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="description company"
     *                 ),
     *                 @OA\Property(
     *                     property="address",
     *                     type="object",
     *                     @OA\Property(property="province", type="string", example="Podlaskie"),
     *                     @OA\Property(property="city", type="string", example="Bialystok"),
     *                     @OA\Property(property="address", type="string", example=""),
     *                     @OA\Property(property="street", type="string", example="Dluga 10"),
     *                     @OA\Property(property="postal", type="string", example="34-200")
     *                 ),
     *                 @OA\Property(
     *                     property="active",
     *                     type="bool",
     *                     example=true
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="400", description="")
     * )
     */
    public function __invoke(Request $request): View
    {
//        $body = $request->getContent();
//        $data = json_decode($body, true);
        $data = $request->request->all();
        $form = $this->formFactory->createNamed('company', CompanyFromType::class, null);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $companyId = $this->useCase->execute(
            $this->getUser()->getId(),
            $form->getData()
        );

        return $this->view(['companyId' => (string) $companyId], Response::HTTP_OK);
    }
}
