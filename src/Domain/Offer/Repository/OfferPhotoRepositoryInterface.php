<?php
declare(strict_types=1);

namespace App\Domain\Offer\Repository;

use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Id\OfferPhotoId;
use App\Domain\Offer\Model\OfferPhoto;

interface OfferPhotoRepositoryInterface
{
    public function save(OfferPhoto $photo): void;

    public function remove(OfferPhoto $photo): void;

    public function findOneByIdOfferId(OfferPhotoId $photoId, OfferId $offerId): ?OfferPhoto;
}
