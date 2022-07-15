<?php

declare(strict_types=1);

namespace App\Domain\Core\Search\Context;

interface ContextFactoryInterface
{
    public function create(string $name, array $params = []): ContextInterface;
}
