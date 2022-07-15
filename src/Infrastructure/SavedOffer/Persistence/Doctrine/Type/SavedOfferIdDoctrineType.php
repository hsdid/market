<?php

namespace App\Infrastructure\SavedOffer\Persistence\Doctrine\Type;

use App\Domain\Core\Id\SavedOfferId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class SavedOfferIdDoctrineType extends GuidType
{
    public const NAME = 'saved_offer_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?SavedOfferId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof SavedOfferId) {
            return $value;
        }

        return new SavedOfferId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        if ($value instanceof SavedOfferId) {
            return (string) $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
