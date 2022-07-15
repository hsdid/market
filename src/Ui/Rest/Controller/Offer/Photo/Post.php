<?php

namespace App\Ui\Rest\Controller\Offer\Photo;

use App\Application\Offer\UseCase\Photo\AddOfferPhotoUseCase;
use App\Domain\Offer\Offer;
use App\Infrastructure\Offer\Form\Type\OfferPhotoFormType;
use App\Infrastructure\Offer\Voter\OfferVoter;
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
    private AddOfferPhotoUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        AddOfferPhotoUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.offer.photo.add", path="/api/offer/{offer}/photo")
     */
    public function __invoke(Request $request, Offer $offer): View
    {
        if (!$this->isGranted(OfferVoter::EDIT, $offer)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }

        $data = $request->request->all();

        $files = $request->files->get('files');
        $data['files'] = $files;

        $form = $this->formFactory->createNamed('photo', OfferPhotoFormType::class);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->useCase->execute(
                $offer->getOfferId(),
                $form->getData()['files']
            );

        } catch (\InvalidArgumentException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
