<?php
declare(strict_types=1);

namespace App\Domain\Core\Search;

interface SearchableInterface
{
    public function findByCriteria(CriteriaCollectionInterface $criteria): array;

    public function countByCriteria(CriteriaCollectionInterface $criteria): int;
}
