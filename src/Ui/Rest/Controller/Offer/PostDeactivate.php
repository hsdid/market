<?php
declare(strict_types=1);
namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\Exception\AlreadyDeactivated;
use App\Application\Offer\Exception\OfferNotFoundException;
use App\Application\Offer\UseCase\DeactivateOfferUseCase;
use App\Domain\Offer\Offer;
use App\Infrastructure\Offer\Voter\OfferVoter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

final class PostDeactivate extends AbstractFOSRestController
{
    private DeactivateOfferUseCase $useCase;

    public function __construct(DeactivateOfferUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.offer.deactivate", path="/api/offer/{offer}/deactivate")
     * @OA\Post(
     *     path="/api/offer/{offer}/deactivate",
     *     tags={"Offer"},
     *     description="Offer Deactivate",
     *     operationId="PostDeactivateOffer",
     *     summary="Deactivate offer",
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
     *      @OA\Response(response="403", description=""),
     * )
     */
    public function __invoke(Request $request, Offer $offer): View
    {
        if (! $this->isGranted(OfferVoter::EDIT, $offer)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }

        try {
            $this->useCase->execute($offer->getOfferId());
        } catch (AlreadyDeactivated $e) {
            return $this->view(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        } catch (OfferNotFoundException $e) {
            return $this->view(
                $e->getMessage(),
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->view(['offerId' => (string) $offer->getOfferId()], Response::HTTP_OK);
    }
}
