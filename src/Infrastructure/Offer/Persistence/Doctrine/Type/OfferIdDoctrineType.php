<?php

namespace App\Infrastructure\Offer\Persistence\Doctrine\Type;

use App\Domain\Core\Id\OfferId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class OfferIdDoctrineType extends GuidType
{
    public const NAME = 'offer_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?OfferId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof OfferId) {
            return $value;
        }

        return new OfferId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        if ($value instanceof OfferId) {
            return (string) $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
