<?php
declare(strict_types=1);

namespace App\Domain\Offer\Exception;

class EmptyPhotoPathException extends \DomainException
{
    public static function create(): self
    {
        return new self('Photo path is required and can not be empty!');
    }
}
