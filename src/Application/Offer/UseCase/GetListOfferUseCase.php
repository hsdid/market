<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase;

use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Core\Search\Responder\SearchableResponderInterface;
use App\Domain\Core\Search\Responder\SearchableResponse;
use App\Domain\Offer\ReadModel\ReadOfferRepositoryInterface;

class GetListOfferUseCase
{
    private SearchableResponderInterface $searchableResponder;
    private ReadOfferRepositoryInterface $offerRepository;

    public function __construct(
        SearchableResponderInterface $searchableResponder,
        ReadOfferRepositoryInterface $offerRepository
    ) {
       $this->searchableResponder = $searchableResponder;
       $this->offerRepository = $offerRepository;

    }

    public function execute(CriteriaCollectionInterface $criteriaCollection): SearchableResponse
    {
        return $this->searchableResponder->fromCriteria($this->offerRepository, $criteriaCollection);
    }
}
