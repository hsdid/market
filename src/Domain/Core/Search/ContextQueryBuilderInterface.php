<?php
declare(strict_types=1);

namespace App\Domain\Core\Search;

use App\Domain\Core\Search\Context\ContextInterface;

interface ContextQueryBuilderInterface
{
    public function buildQuery(ContextInterface $context, CriteriaCollectionInterface $criteriaCollection): void;
}
