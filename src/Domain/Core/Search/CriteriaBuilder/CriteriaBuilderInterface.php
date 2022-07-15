<?php

namespace App\Domain\Core\Search\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;

interface CriteriaBuilderInterface
{
    public function build(ContextInterface $context, CriteriaInterface $criteria): void;

    public function allows(CriteriaInterface $criteria): bool;
}