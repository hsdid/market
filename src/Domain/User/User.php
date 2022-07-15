<?php
declare(strict_types=1);
namespace App\Domain\User;

use App\Domain\Core\Id\UserId;

class User
{
    protected UserId $id;
    protected string $firstName;
    protected string $lastName;
    protected ?string $email = null;
    protected \DateTimeInterface $createdAt;
    protected bool $active = true;

    public static function registerUser(UserId $userId, array $userData): User
    {
        $user = new self();
        return $user;
    }
}