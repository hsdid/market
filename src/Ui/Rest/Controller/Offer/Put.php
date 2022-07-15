<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\Exception\CompanyNotBelongToUser;
use App\Application\Offer\Exception\CompanyNotFoundException;
use App\Application\Offer\UseCase\UpdateOfferUseCase;
use App\Domain\Offer\Offer;
use App\Infrastructure\Offer\Form\Type\EditOfferFormType;
use App\Infrastructure\Offer\Voter\OfferVoter;
use OpenApi\Annotations as OA;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


final class Put extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private UpdateOfferUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        UpdateOfferUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"PUT"}, name="api.offer.update", path="/api/offer/{offer}")
     * @OA\Put(
     *     path="/api/offer/{offer}",
     *     tags={"Offer"},
     *     description="Update Offer",
     *     operationId="offerPut",
     *     summary="Update offer",
     *     @OA\PathParameter(
     *          name="offer",
     *          in="query",
     *          @OA\Schema(type="string", example="45d04bcc-610a-4f95-a2ba-e681ffdbbd77")
     *     ),
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
     *                     property="price",
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
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="offerId",
     *                     type="string",
     *                     format="uuid",
     *                     description="offer member identity",
     *                     example="00000000-0000-0000-0000-000000000000"
     *                 )
     *             )
     *         )
     *      ),
     *      @OA\Response(response="400", description=""),
     *      @OA\Response(response="403", description="")
     * )
     */
    public function __invoke(Request $request, Offer $offer): View
    {
        if (!$this->isGranted(OfferVoter::EDIT, $offer)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }
//        $body = $request->getContent();
//        $data = json_decode($body, true);
        $data = $request->request->all();
        $form = $this->formFactory->createNamed('offer', EditOfferFormType::class, null);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $offerId = $this->useCase->execute($offer->getOfferId(), $form->getData());
        } catch (CompanyNotFoundException $e) {
            $form->addError(new FormError($e->getMessage()));
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        } catch (CompanyNotBelongToUser $e) {
            $form->addError(new FormError($e->getMessage()));
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        return $this->view(['offerId' => (string) $offerId], Response::HTTP_OK);
    }
}
