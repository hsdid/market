<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Persistence\Doctrine\Repository;

use App\Domain\Core\Model\Identifier;
use App\Domain\Core\Search\Context\ContextFactoryInterface;
use App\Domain\Core\Search\Context\ContextInterface;
use App\Domain\Core\Search\ContextQueryBuilderInterface;
use App\Domain\Core\Search\Criteria\OrderByCriteria;
use App\Domain\Core\Search\Criteria\PaginationCriteria;
use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Infrastructure\Core\Search\Doctrine\Context;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    protected EntityRepository $entityRepository;
    protected EntityManagerInterface $entityManager;
    protected ContextQueryBuilderInterface $queryBuilder;
    protected ContextFactoryInterface $contextFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContextQueryBuilderInterface $queryBuilder,
        ContextFactoryInterface $contextFactory
    ) {
        $this->entityRepository = $entityManager->getRepository($this->getClass());;
        $this->entityManager = $entityManager;
        $this->queryBuilder = $queryBuilder;
        $this->contextFactory = $contextFactory;
    }

    abstract protected function getClass(): string;

    protected function getBaseContext(array $params): ContextInterface
    {
        return $this->contextFactory->create(
            substr(strrchr($this->getClass(), '\\'), 1),
            $params
        );
    }

    public function findByCriteria(CriteriaCollectionInterface $criteria): array
    {
        $context = $this->getBaseContext(
            [
                Context::CLASS_PARAM => $this->getClass(),
            ]
        );

        try {
            $this->queryBuilder->buildQuery($context, $criteria);
        } catch (\Exception $ex) {
            return [];
        }

        $queryBuilder = $context->getQueryBuilder();
        $queryBuilder->select(Context::DEFAULT_ALIAS);

        return $context->getQueryBuilder()->getQuery()->getResult();
    }

    public function countByCriteria(CriteriaCollectionInterface $criteria): int
    {
        $context = $this->getBaseContext(
            [
                Context::CLASS_PARAM => $this->getClass(),
                ContextInterface::EXCLUDE_PARAM => [
                    PaginationCriteria::class,
                    OrderByCriteria::class,
                ],
            ]
        );

        try {
            $this->queryBuilder->buildQuery($context, $criteria);
        } catch (\Exception $ex) {
            return 0;
        }

        $queryBuilder = $context->getQueryBuilder();
        $queryBuilder
            ->select(sprintf('COUNT(%s)', Context::DEFAULT_ALIAS));

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function find(Identifier $id): ?object
    {
        return $this->entityRepository->find($id);
    }

    public function findOneBy(array $criteria): ?object
    {
        return $this->entityRepository->findOneBy($criteria);
    }

    public function findAll(): array
    {
        return $this->entityRepository->findAll();
    }

    public function findBy(array $criteria, ?array $orderBy = null, int $limit = null, int $offset = null): array
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }
}
