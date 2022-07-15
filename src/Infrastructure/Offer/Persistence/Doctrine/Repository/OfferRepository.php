<?php
declare(strict_types=1);

namespace App\Infrastructure\Offer\Persistence\Doctrine\Repository;

use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Search\CriteriaCollectionInterface;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class OfferRepository implements OfferRepositoryInterface
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function save(Offer $offer): void
    {
        $this->em->persist($offer);
        $this->em->flush();
    }

    public function getById(OfferId $id): ?Offer
    {
        return $this->em->find(Offer::class, $id);
    }

    public function remove(Offer $offer): void
    {
        $this->em->remove($offer);
        $this->em->flush();
    }
}
