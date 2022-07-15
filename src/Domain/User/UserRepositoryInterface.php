<?php
declare(strict_types=1);
namespace App\Domain\User;

use App\Domain\Core\Model\Identifier;
use App\Domain\Core\Search\SearchableInterface;

interface UserRepositoryInterface extends SearchableInterface
{
    public function find(Identifier $id);
    public function findByEmail(string $email): ?object;
    public function save(UserInterface $user);
}
