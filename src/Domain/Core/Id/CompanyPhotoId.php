<?php

namespace App\Domain\Core\Id;

use App\Domain\Core\Model\Identifier;
use Assert\Assertion;
use Assert\AssertionFailedException;

class CompanyPhotoId implements Identifier
{
    protected string $photoId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $photoId)
    {
        Assertion::uuid($photoId);
        $this->photoId = $photoId;
    }

    public function __toString(): string
    {
        return $this->photoId;
    }
}