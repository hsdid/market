<?php
declare(strict_types=1);

namespace App\Infrastructure\Company\Persistence\Doctrine\Repository;

use App\Domain\Company\CompanyPhotoRepositoryInterface;
use App\Domain\Company\Model\CompanyPhoto;
use Doctrine\ORM\EntityManagerInterface;

class CompanyPhotoRepository implements CompanyPhotoRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(CompanyPhoto $photo): void
    {
        $this->em->persist($photo);
        $this->em->flush();
    }

    public function remove(CompanyPhoto $photo): void
    {
        $this->em->remove($photo);
        $this->em->flush();
    }
}
