<?php

namespace App\Application\Offer\Command;

use App\Domain\Core\Id\OfferId;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddPhotoCommand extends OfferCommand
{
    /**
     * @var UploadedFile[]
     */
    private array $files;
    protected OfferId $offerId;
    public function __construct(array $files, OfferId $offerId)
    {
        parent::__construct($offerId);
        $this->files = $files;
    }

    public static function withData(array $uploadedFiles, OfferId $offerId): self
    {
        return new self($uploadedFiles, $offerId);
    }

    /**
     * @return UploadedFile[]
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}
