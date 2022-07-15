<?php
declare(strict_types=1);
namespace App\Application\Offer\Command;

use App\Domain\Core\Id\OfferId;

class DeactivateOfferCommand extends OfferCommand
{
    public function __construct(OfferId $offerId)
    {
        parent::__construct($offerId);
    }
}
