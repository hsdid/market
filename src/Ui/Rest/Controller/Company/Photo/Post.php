<?php

namespace App\Ui\Rest\Controller\Company\Photo;

use App\Application\Company\UseCase\Photo\AddCompanyPhotoUseCase;
use App\Domain\Company\Company;
use App\Domain\Offer\Offer;
use App\Infrastructure\Company\Form\CompanyPhotoFormType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Post extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private AddCompanyPhotoUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        AddCompanyPhotoUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"POST"}, name="api.company.photo.add", path="/api/company/{company}/photo")
     * @param Request $request
     * @param Company $company
     * @return View
     */
    public function __invoke(Request $request, Company $company): View
    {
        $files = $request->files->get('files');
        $data['files'] = $files;

        $form = $this->formFactory->createNamed('photo', CompanyPhotoFormType::class);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->useCase->execute(
                $company,
                $form->getData()['files']
            );

        } catch (\InvalidArgumentException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
