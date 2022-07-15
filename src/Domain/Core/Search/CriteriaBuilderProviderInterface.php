<?php
declare(strict_types=1);

namespace App\Domain\Core\Search;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\CriteriaBuilder\CriteriaBuilderInterface;

interface CriteriaBuilderProviderInterface
{
    /**
     * @return CriteriaBuilderInterface[]
     */
    public function getCriteriaBuilders(ContextInterface $context): array;
}
