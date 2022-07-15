<?php

namespace App\Domain\Company;

use App\Domain\Company\Model\CompanyPhoto;

interface CompanyPhotoRepositoryInterface
{
    public function save(CompanyPhoto $photo): void;
    public function remove(CompanyPhoto $photo): void;
}
