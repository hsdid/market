<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Persistence\Doctrine\Repository;

use App\Domain\Core\Search\Context\ContextFactoryInterface;
use App\Domain\Core\Search\ContextQueryBuilderInterface;
use App\Domain\User\UserInterface;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\Core\Persistence\Doctrine\Repository\DoctrineRepository;
use App\Infrastructure\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository extends DoctrineRepository implements UserRepositoryInterface
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

    public function findByEmail(string $email): ?object
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function save(UserInterface $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    protected function getClass(): string
    {
        return User::class;
    }
}
