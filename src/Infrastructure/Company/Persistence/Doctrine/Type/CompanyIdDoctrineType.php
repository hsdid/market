<?php

namespace App\Infrastructure\Company\Persistence\Doctrine\Type;

use App\Domain\Core\Id\CompanyId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class CompanyIdDoctrineType extends GuidType
{
    public const NAME = 'company_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CompanyId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof CompanyId) {
            return $value;
        }

        return new CompanyId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null == $value) {
            return null;
        }

        if ($value instanceof CompanyId) {
            return (string) $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
