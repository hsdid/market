<?php
declare(strict_types=1);

namespace App\Domain\Offer;

use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Search\SearchableInterface;

interface OfferRepositoryInterface
{
    public function save(Offer $offer): void;

    public function getById(OfferId $offerId): ?Offer;

    public function remove(Offer $offer): void;
}
