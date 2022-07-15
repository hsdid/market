<?php

namespace App\Application\Company\Command\Photo;

use App\Domain\Company\Company;
use App\Domain\Core\Id\CompanyId;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class AddCompanyPhotoCommand
{
    private Company $company;
    /**
     * @var UploadedFile[]
     */
    private array $files;

    public function __construct(
        Company $company,
        array $files
    ) {
        $this->company = $company;
        $this->files = $files;
    }

    public static function withData(Company $company, array $uploadedFiles): self
    {
        return new self($company, $uploadedFiles);
    }

    /**
     * @return array
     */
    public function getFiles(): array
    {
        return $this->files;
    }

    /**
     * @return Company
     */
    public function getCompany(): Company
    {
        return $this->company;
    }

}
