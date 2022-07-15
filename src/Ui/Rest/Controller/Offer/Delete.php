<?php
declare(strict_types=1);

namespace App\Ui\Rest\Controller\Offer;

use App\Application\Offer\UseCase\DeleteOfferUseCase;
use App\Domain\Offer\Offer;
use App\Infrastructure\Offer\Voter\OfferVoter;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

final class Delete extends AbstractFOSRestController
{
    private DeleteOfferUseCase $useCase;

    public function __construct(DeleteOfferUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"DELETE"}, name="api.offer.delete", path="/api/offer/{offer}")
     * @param Offer $offer
     * @return View
     */
    public function __invoke(Offer $offer): View
    {
        if (!$this->isGranted(OfferVoter::EDIT, $offer)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }

        $this->useCase->execute($offer);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
