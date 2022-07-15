<?php
declare(strict_types=1);

namespace App\Application\Company\UseCase;

use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Core\Search\Responder\SearchableResponderInterface;
use App\Domain\Core\Search\Responder\SearchableResponse;

class GetListCompanyUseCase
{
    private SearchableResponderInterface $searchableResponder;
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(
        SearchableResponderInterface $searchableResponder,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->searchableResponder = $searchableResponder;
        $this->companyRepository = $companyRepository;
    }

    public function execute(CriteriaCollectionInterface $criteriaCollection): SearchableResponse
    {
        return $this->searchableResponder->fromCriteria($this->companyRepository, $criteriaCollection);
    }
}
