<?php

namespace App\Domain\Core\Id;

use App\Domain\Core\Model\Identifier;
use Assert\Assertion as Assert;
use Assert\AssertionFailedException;

class SavedOfferId implements Identifier
{
    protected string $savedOfferId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $savedOfferId)
    {
        Assert::uuid($savedOfferId);
        $this->savedOfferId = $savedOfferId;
    }

    public function __toString(): string
    {
        return $this->savedOfferId;
    }
}
