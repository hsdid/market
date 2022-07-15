<?php
declare(strict_types=1);
namespace App\Domain\User;

use App\Domain\Core\Id\UserId;

class UserFactory implements UserFactoryInterface
{

    public function create(UserId $userId, array $userData): UserInterface
    {
        return User::registerUser($userId, $userData);
    }
}