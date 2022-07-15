<?php

namespace App\Infrastructure\Company\Persistence\Doctrine\Type;

use App\Domain\Core\Id\CompanyPhotoId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class CompanyPhotoIdDoctrineType extends GuidType
{
    public const NAME = 'company_photo_id';

    public function convertToPHPValue($value, AbstractPlatform $platform):?CompanyPhotoId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof CompanyPhotoId) {
            return $value;
        }

        return new CompanyPhotoId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        if ($value instanceof CompanyPhotoId) {
            return (string) $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
