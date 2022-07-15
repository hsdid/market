<?php

declare(strict_types=1);

namespace App\Ui\Rest\Controller\Company;

use App\Application\Company\UseCase\UpdateCompanyUseCase;
use App\Domain\Company\Company;
use App\Infrastructure\Company\Voter\CompanyVoter;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use App\Infrastructure\Company\Form\EditCompanyFormType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class Put extends AbstractFOSRestController
{
    private FormFactoryInterface $formFactory;
    private UpdateCompanyUseCase $useCase;

    public function __construct(
        FormFactoryInterface $formFactory,
        UpdateCompanyUseCase $useCase
    ) {
        $this->formFactory = $formFactory;
        $this->useCase = $useCase;
    }

    /**
     * @Route(methods={"PUT"}, name="api.company.update", path="/api/company/{company}")
     *
     * @param Request $request
     * @param Company $company
     * @return View
     */
    public function __invoke(Request $request, Company $company): View
    {

        if (!$this->isGranted(CompanyVoter::EDIT, $company)) {
            return $this->view('Access denied', Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();
        ///$body = $request->getContent();
        //$data = json_decode($body, true);

        $form = $this->formFactory->createNamed('company', EditCompanyFormType::class, [], [
            'method' => 'PUT'
        ]);
        $form->submit($data);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $companyId = $this->useCase->execute($company->getCompanyId(), $form->getData());

        return $this->view(['companyId' => (string) $companyId], Response::HTTP_NO_CONTENT);
    }
}
