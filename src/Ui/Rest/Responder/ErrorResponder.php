<?php
declare(strict_types=1);
namespace App\Ui\Rest\Responder;

use FOS\RestBundle\View\View;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;

class ErrorResponder implements ErrorResponderInterface
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function fromString(string $message, ?int $responseCode = null): View
    {
        $form = $this->formFactory->createNamed('', FormType::class);
        $form->addError(new FormError(
            $message
        ));

        return View::create($form, $responseCode ?? Response::HTTP_BAD_REQUEST);
    }
}
