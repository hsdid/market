<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Search\Doctrine;

use App\Domain\Core\Search\Context\ContextFactoryInterface;
use App\Domain\Core\Search\Context\ContextInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContextFactory implements ContextFactoryInterface
{
    protected EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(string $name, array $params = []): ContextInterface
    {
        return new Context($name, $this->entityManager, $params);
    }
}
