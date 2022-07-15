<?php
declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Core\Search\Responder\SearchableResponderInterface;
use App\Domain\Core\Search\Responder\SearchableResponse;
use App\Domain\User\UserRepositoryInterface;

class GetUserListUseCase
{
    private SearchableResponderInterface $searchableResponder;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        SearchableResponderInterface $searchableResponder
    ) {
        $this->userRepository = $userRepository;
        $this->searchableResponder = $searchableResponder;
    }

    public function execute(CriteriaCollectionInterface $criteriaCollection): SearchableResponse
    {
        return $this->searchableResponder->fromCriteria($this->userRepository, $criteriaCollection);
    }
}
