<?php

declare(strict_types=1);

namespace App\Domain\Core\Search\Context;

interface ContextInterface
{
    public const CONTEXT_SEPARATOR = '/';
    public const EXCLUDE_PARAM = 'exclude';

    public function getQueryBuilder(): object;

    public function getName(): string;

    /**
     * @return mixed
     */
    public function getParam(string $name);
}
