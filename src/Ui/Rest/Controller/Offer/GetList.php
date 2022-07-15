<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\UseCase\GetListOfferUseCase;
use App\Infrastructure\Core\Form\Search\Symfony\SearchFormFactoryInterface;
use App\Infrastructure\Offer\Form\Type\OfferSearchType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\View\View;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class GetList extends AbstractFOSRestController
{
    private GetListOfferUseCase $useCase;
    private SearchFormFactoryInterface $searchFormFactory;

    public function __construct(GetListOfferUseCase $useCase, SearchFormFactoryInterface $searchFormFactory)
    {
        $this->useCase = $useCase;
        $this->searchFormFactory = $searchFormFactory;
    }

    /**
     * @Route(methods={"GET"}, name="api.offer.getList", path="/api/offer")
     * @OA\Get(
     *     path="/api/offer",
     *     tags={"Offer"},
     *     operationId="offerGetList",
     *     summary="Get offer list",
     *     @OA\Response(
     *         response="200",
     *         description="Offer List",
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
            OfferSearchType::class,
            $request->query->all()
        );

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $result = $this->useCase->execute($form->getData());

        return $this->view($result, Response::HTTP_OK);
    }
}