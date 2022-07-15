<?php

namespace App\Domain\Core\Id;

use App\Domain\Core\Model\Identifier;
use Assert\Assertion as Assert;
use Assert\AssertionFailedException;

class OfferPhotoId implements Identifier
{
    protected string $photoId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $photoId)
    {
        Assert::uuid($photoId);
        $this->photoId = $photoId;
    }

    public function __toString(): string
    {
        return $this->photoId;
    }
}
