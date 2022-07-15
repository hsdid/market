<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Persistence\Doctrine\Repository;

use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Id\OfferPhotoId;
use App\Domain\Offer\Model\OfferPhoto;
use App\Domain\Offer\Repository\OfferPhotoRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class OfferPhotoRepository implements OfferPhotoRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(OfferPhoto $photo): void
    {
        $this->em->persist($photo);
        $this->em->flush();
    }

    public function remove(OfferPhoto $photo): void
    {
        $this->em->remove($photo);
        $this->em->flush();
    }

    public function findOneByIdOfferId(OfferPhotoId $photoId, OfferId $offerId): ?OfferPhoto
    {
        return $this
            ->em
            ->getRepository(OfferPhoto::class)
            ->findOneBy(['offer' => $offerId, 'photoId' => $photoId]);
    }
}
