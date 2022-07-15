<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Form\Search\Symfony;

use Symfony\Component\Form\FormInterface;

interface SearchFormFactoryInterface
{
    public function createAndHandle(string $formType, array $params, array $options = []): FormInterface;
}
