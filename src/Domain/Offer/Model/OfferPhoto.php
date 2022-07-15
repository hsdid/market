<?php

namespace App\Domain\Offer\Model;

use App\Domain\Core\Id\OfferPhotoId;
use App\Domain\Offer\Offer;

class OfferPhoto
{
    private OfferPhotoId $photoId;
    private Offer $offer;
    private string $path;
    private string $originalName;
    private string $mimeType;

    public function __construct(
        OfferPhotoId $photoId,
        Offer $offer,
        string $path,
        string $originalName,
        string $mimeType
    ) {
        $this->photoId = $photoId;
        $this->offer = $offer;
        $this->path = $path;
        $this->originalName = $originalName;
        $this->mimeType = $mimeType;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }
}
