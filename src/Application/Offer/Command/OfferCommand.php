<?php
declare(strict_types=1);

namespace App\Application\Offer\Command;

use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Message\Command;

abstract class OfferCommand implements Command
{
    protected OfferId $offerId;

    public function __construct(OfferId $offerId)
    {
        $this->offerId = $offerId;
    }

    public function getOfferId(): OfferId
    {
        return $this->offerId;
    }
}
