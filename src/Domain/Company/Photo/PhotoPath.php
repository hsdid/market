<?php

namespace App\Domain\Company\Photo;

use App\Domain\Offer\Exception\EmptyPhotoPathException;

class PhotoPath
{
    public const PHOTO_DIR = 'company/uploads/';
    private string $value;

    public function __construct(string $path)
    {
        if (empty($path)) {
            throw EmptyPhotoPathException::create();
        }

        $this->value = self::PHOTO_DIR.$path;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
