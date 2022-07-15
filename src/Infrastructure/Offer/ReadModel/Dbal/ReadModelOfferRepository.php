<?php
declare(strict_types=1);
namespace App\Infrastructure\Offer\ReadModel\Dbal;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Search\Context\ContextFactoryInterface;
use App\Domain\Core\Search\ContextQueryBuilderInterface;
use App\Domain\Offer\Offer;
use App\Domain\Offer\ReadModel\ReadOfferRepositoryInterface;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Infrastructure\Core\Persistence\Doctrine\Repository\DoctrineRepository;
use App\Infrastructure\Offer\ReadModel\OfferView;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;


class ReadModelOfferRepository extends DoctrineRepository implements ReadOfferRepositoryInterface
{
    private Connection $connection;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContextQueryBuilderInterface $queryBuilder,
        ContextFactoryInterface $contextFactory,
        Connection $connection
    ) {
        parent::__construct($entityManager, $queryBuilder, $contextFactory);
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function getAllOffers(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder
            ->select(
                'o.id as offerId, o.user_id as userId,
                o.title, o.description, o.company_id as companyId, 
                o.created_at as createdAt, o.active, o.price_minprice as minPrice,
                o.price_maxprice as maxPrice')
            ->from('offer', 'o')
            ->executeQuery();

        $offersData = $statement->fetchAllAssociative();

        //To-do przeniesc mapowanie
        return array_map(function(array $offerData) {
            return new OfferView(
                $offerData['offerid'],
                $offerData['userid'],
                $offerData['title'],
                $offerData['description'],
                $offerData['companyid'],
                new PriceRange(
                    (float) $offerData['minprice'],
                    (float) $offerData['minprice']
                ),
                new DateTimeImmutable($offerData['createdat']),
                $offerData['active'],
            );
        }, $offersData);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getCompanyOffers(CompanyId $companyId): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $statement = $queryBuilder
            ->select(
                'o.id as offerId, o.user_id as userId,
                o.title, o.description, o.company_id as companyId, 
                o.created_at as createdAt, o.active, o.price_minprice as minPrice,
                o.price_maxprice as maxPrice')
            ->from('offer', 'o')
            ->where('o.company_id = :companyId')
            ->setParameter('companyId', (string) $companyId)
            ->executeQuery();

        $offersData = $statement->fetchAllAssociative();

        //To-do przeniesc mapowanie
        return array_map(function(array $offerData) {
            return new OfferView(
                $offerData['offerid'],
                $offerData['userid'],
                $offerData['title'],
                $offerData['description'],
                $offerData['companyid'],
                new PriceRange(
                    (float) $offerData['minprice'],
                    (float) $offerData['minprice']
                ),
                new DateTimeImmutable($offerData['createdat']),
                $offerData['active'],
            );
        }, $offersData);
    }

    protected function getClass(): string
    {
        return Offer::class;
    }
}
