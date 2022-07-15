<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Domain\Offer\Offer;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

final class Get extends AbstractFOSRestController
{
    /**
     * @Route(methods={"GET"}, name="api.offer.get", path="/api/offer/{offer}")
     * @OA\Get(
     *     path="/api/offer/{offer}",
     *     tags={"Offer"},
     *     operationId="offerGet",
     *     summary="Get offer by id",
     *     @OA\PathParameter(
     *          name="offer",
     *          in="query",
     *          @OA\Schema(type="string", example="45d04bcc-610a-4f95-a2ba-e681ffdbbd77")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Offer details",
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *              )
     *         )
     *      ),
     *      @OA\Response(response="404", description="User not found")
     * )
     */
    public function __invoke(Offer $offer): View
    {
        return $this->view($offer);
    }
}
