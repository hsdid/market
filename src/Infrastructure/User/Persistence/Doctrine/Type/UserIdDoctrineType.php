<?php

namespace App\Infrastructure\User\Persistence\Doctrine\Type;

use App\Domain\Core\Id\UserId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

class UserIdDoctrineType extends GuidType
{
    public const NAME = 'user_id';

    /**
     * @throws \Assert\AssertionFailedException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof UserId) {
            return $value;
        }

        return new UserId($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof UserId) {
            return (string) $value;
        }

        if (!empty($value)) {
            return $value;
        }

        return null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
