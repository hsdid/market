<?php

namespace App\Domain\Core\Search\CriteriaCollection;

use App\Domain\Core\Search\Criteria\CriteriaInterface;
use App\Domain\Core\Search\CriteriaCollectionInterface;

class CriteriaCollection implements CriteriaCollectionInterface, \IteratorAggregate
{
    /**
     * @var CriteriaInterface[]
     */
    protected array $criteria = [];

    public function add(CriteriaInterface $criteria): void
    {
        $this->criteria[] = $criteria;
    }

    /**
     * @return CriteriaInterface[]
     */
    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->criteria);
    }
}
