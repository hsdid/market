<?php

namespace App\Domain\Core\Id;

use Assert\Assertion as Assert;
use App\Domain\Core\Model\Identifier;
use Assert\AssertionFailedException;

class UserId implements Identifier
{
    protected string $userId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $userId)
    {
        Assert::uuid($userId);
        $this->userId = $userId;
    }

    public function __toString(): string
    {
        return $this->userId;
    }
}