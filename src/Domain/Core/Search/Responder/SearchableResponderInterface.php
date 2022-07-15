<?php

namespace App\Domain\Core\Search\Responder;

use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Core\Search\SearchableInterface;

interface SearchableResponderInterface
{
    public function fromCriteria(
        SearchableInterface $searchable,
        CriteriaCollectionInterface $collection
    ): SearchableResponse;
}