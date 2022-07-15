<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\Exception\AlreadyActivated;
use App\Application\Offer\UseCase\ActivateOfferUseCase;
use App\Domain\Offer\Offer;
use App\Infrastructure\Offer\Voter\OfferVoter;
use App\Ui\Rest\Responder\ErrorResponderInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

final class PostActivate extends AbstractFOSRestController
{
    private ActivateOfferUseCase $useCase;
    private ErrorResponderInterface $errorResponder;

    public function __construct(
        ActivateOfferUseCase $useCase,
        ErrorResponderInterface $errorResponder
    ) {
        $this->useCase = $useCase;
        $this->errorResponder = $errorResponder;
    }

    /**
     * @Route(methods={"POST"}, name="api.offer.activate", path="/api/offer/{offer}/activate")
     * @OA\Post(
     *     path="/api/offer/{offer}/activate",
     *     tags={"Offer"},
     *     description="Offer Activate",
     *     operationId="PostActivateOffer",
     *     summary="Activate offer",
     *     @OA\PathParameter(
     *          name="offer",
     *          in="query",
     *          @OA\Schema(type="string", example="45d04bcc-610a-4f95-a2ba-e681ffdbbd77")
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
        if (! $this->isGranted(OfferVoter::EDIT, $offer)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }

        try {
            $this->useCase->execute($offer->getOfferId());
        } catch (AlreadyActivated $exception) {
            return $this->errorResponder->fromString(
                $exception->getMessage()
            );
        }

        return $this->view(['offerId' => (string) $offer->getOfferId()], Response::HTTP_OK);
    }
}
