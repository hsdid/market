<?php
declare(strict_types=1);

namespace App\Domain\Core;

use App\Domain\Core\Model\Identifier;
use App\Domain\Core\Search\SearchableInterface;

interface Repository extends SearchableInterface
{
    public function find(Identifier $id): ?object;

    public function findAll(): array;

    public function findBy(array $criteria, ?array $orderBy = null, int $limit = null, int $offset = null): array;

    public function findOneBy(array $criteria): ?object;
}
