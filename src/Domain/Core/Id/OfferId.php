<?php
declare(strict_types=1);
namespace App\Domain\Core\Id;

use App\Domain\Core\Model\Identifier;
use Assert\Assertion as Assert;
use Assert\AssertionFailedException;

class OfferId implements Identifier
{
    protected string $offerId;

    /**
     * @throws AssertionFailedException
     */
    public function __construct(string $offerId)
    {
        Assert::uuid($offerId);
        $this->offerId = $offerId;
    }

    public function __toString(): string
    {
        return $this->offerId;
    }
}
