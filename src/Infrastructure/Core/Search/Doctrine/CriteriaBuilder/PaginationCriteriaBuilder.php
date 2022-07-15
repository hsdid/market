<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine\CriteriaBuilder;

use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\Criteria\PaginationCriteria;

final class PaginationCriteriaBuilder extends BaseCriteriaBuilder
{
    public function build(ContextInterface $context, CriteriaInterface $criteria): void
    {
        if (!$criteria instanceof PaginationCriteria) {
            return;
        }

        $queryBuilder = $context->getQueryBuilder();

        $queryBuilder->setFirstResult(($criteria->getPage() - 1) * $criteria->getItemsPerPage());
        $queryBuilder->setMaxResults($criteria->getItemsPerPage());
    }

    public function allows(CriteriaInterface $criteria): bool
    {
        return $criteria instanceof PaginationCriteria;
    }
}
