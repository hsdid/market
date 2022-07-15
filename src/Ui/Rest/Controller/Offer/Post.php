<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\Exception\CompanyNotBelongToUser;
use App\Application\Offer\Exception\CompanyNotFoundException;
use App\Application\Offer\UseCase\CreateOfferUseCase;
use App\Infrastructure\Offer\Form\Type\OfferFormType;
use Assert\AssertionFailedException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use OpenApi\Tests\Annotations\ValidateRelationsTest;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;

final class Post extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private CreateOfferUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        CreateOfferUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.offer.create", path="/api/offer")
     * @OA\Post(
     *     path="/api/offer",
     *     tags={"Offer"},
     *     description="Create offer",
     *     operationId="offerCreate",
     *     summary="Create offer",
     *     @OA\RequestBody(
     *         description="",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="title",
     *                     type="string",
     *                     example="offer title"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="description offer"
     *                 ),
     *                 @OA\Property(
     *                     property="priceRange",
     *                     type="object",
     *                     @OA\Property(property="minPrice", type="number"),
     *                     @OA\Property(property="maxPrice", type="number")
     *                 ),
     *                 @OA\Property(
     *                     property="companyId",
     *                     type="string",
     *                     example="c5dc1d31-eb7e-410b-a44c-0f06a4377182"
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
        $form = $this->formFactory->createNamed('offer', OfferFormType::class, null);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $offerId = $this->useCase->execute(
                $this->getUser()->getId(),
                $form->getData()
            );

            return $this->view(['offerId' => (string) $offerId], Response::HTTP_OK);
        } catch (CompanyNotFoundException $e) {
            $form->get('companyId')->addError(
                new FormError($e->getMessage())
            );
        } catch (CompanyNotBelongToUser $e) {
            $form->get('companyId')->addError(
                new FormError($e->getMessage())
            );
        } catch (AssertionFailedException $e) {
        }

        return $this->view($form, Response::HTTP_BAD_REQUEST);
    }
}
