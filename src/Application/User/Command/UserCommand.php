<?php
declare(strict_types=1);
namespace App\Application\User\Command;

use App\Domain\Core\Id\UserId;
use App\Domain\Core\Message\Command;


abstract class UserCommand implements Command
{
    protected UserId $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId() :UserId
    {
        return $this->userId;
    }
}