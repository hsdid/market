<?php

namespace App\Domain\Core\Search\Responder;

use App\Domain\Core\Search\CriteriaCollection\CriteriaCollection;
use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Core\Search\SearchableInterface;

class SearchableResponder implements SearchableResponderInterface
{
    public function fromCriteria(SearchableInterface $searchable, CriteriaCollectionInterface $criteria): SearchableResponse
    {
        $totalFiltered = $searchable->countByCriteria($criteria);
        $items = $searchable->findByCriteria($criteria);

        $totalAll = $searchable->countByCriteria($this->getCleanCriteria($criteria));

        return new SearchableResponse($items, $totalAll, $totalFiltered);
    }

    protected function getCleanCriteria(CriteriaCollectionInterface $criteriaCollection): CriteriaCollectionInterface
    {
        return new CriteriaCollection();
    }
}