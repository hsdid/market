<?php

namespace App\Infrastructure\Offer\Persistence\Doctrine\Type;

use App\Domain\Core\Id\OfferPhotoId;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class OfferPhotoIdDoctrineType extends GuidType
{
    public const NAME = 'photo_id';

    /**
     * @throws AssertionFailedException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?OfferPhotoId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof OfferPhotoId) {
            return $value;
        }

        return new OfferPhotoId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        if ($value instanceof OfferPhotoId) {
            return (string) $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
