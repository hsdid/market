<?php
declare(strict_types=1);

namespace App\Infrastructure\Company\Persistence\Doctrine\Repository;

use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Search\Context\ContextFactoryInterface;
use App\Domain\Core\Search\ContextQueryBuilderInterface;
use App\Infrastructure\Core\Persistence\Doctrine\Repository\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class CompanyRepository extends DoctrineRepository implements CompanyRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(
        EntityManagerInterface $em,
        ContextQueryBuilderInterface $queryBuilder,
        ContextFactoryInterface $contextFactory
    ) {
        parent::__construct($em, $queryBuilder, $contextFactory);
        $this->em = $em;
    }

    public function save(Company $company): void
    {
        $this->em->persist($company);
        $this->em->flush();
    }

    public function getById(CompanyId $id): ?Company
    {
        return $this->em->find(Company::class, $id);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getByName(string $name): ?Company
    {
        $query = $this->em->createQuery('SELECT c FROM App\Domain\Company\Company c WHERE c.name='."'".$name."'");
        return $query->getOneOrNullResult();
    }

    protected function getClass(): string
    {
        return Company::class;
    }
}
