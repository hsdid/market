<?php

namespace App\Domain\Core\Search;

use App\Domain\Core\Search\Criteria\CriteriaInterface;

interface CriteriaCollectionInterface
{
    public function add(CriteriaInterface $criteria): void;

    public function getCriteria(): array;
}
