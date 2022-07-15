<?php

namespace App\Domain\Company\Model;

use App\Domain\Company\Company;
use App\Domain\Core\Id\CompanyPhotoId;

class CompanyPhoto
{
    private CompanyPhotoId $photoId;
    private Company $company;
    private string $path;
    private string $originalName;
    private string $mimeType;

    public function __construct(
        CompanyPhotoId $companyPhotoId,
        Company $company,
        string $path,
        string $originalName,
        string $mimeType
    ) {
        $this->photoId = $companyPhotoId;
        $this->company = $company;
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