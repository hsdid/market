<?php
declare(strict_types=1);

namespace App\Application\User\Command;

use App\Domain\Core\Id\UserId;
use DateTimeInterface;

class RegisterUserCommand extends UserCommand
{
    protected UserId $userId;
    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected string $password;
    protected bool $isActive;
    protected DateTimeInterface $createdAt;

    public function __construct(
        UserId $userId,
        string $firstName,
        string $lastName,
        string $email,
        string $password,
        bool $isActive,
        DateTimeInterface $createdAt
    ) {
        parent::__construct($userId);
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->isActive = $isActive;
        $this->createdAt = $createdAt;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }
}
