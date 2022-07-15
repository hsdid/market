<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class SearchFormFactory implements SearchFormFactoryInterface
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function createAndHandle(string $formType, array $params, array $options = []): FormInterface
    {
        $form = $this->formFactory->createNamed('', $formType, null, $options + [
                'allow_extra_fields' => true,
                'csrf_protection' => false,
                ]
        );
        $form->submit($params);

        return $form;
    }
}
