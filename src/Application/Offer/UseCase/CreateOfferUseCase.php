<?php
declare(strict_types=1);
namespace App\Application\Offer\UseCase;

use App\Application\Offer\Command\CreateOfferCommand;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Id\UserId;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Domain\Core\Message\CommandBusInterface;
use Assert\AssertionFailedException;
use DateTime;
use Symfony\Component\Uid\Uuid;

class CreateOfferUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws AssertionFailedException
     */
    public function execute(string $userId, array $data): OfferId
    {
        $offerId = new OfferId((string) Uuid::v4());
        //validate if company belongs to user who add offer

        $command = new CreateOfferCommand(
            $offerId,
            new UserId($userId),
            $data['title'],
            $data['description'],
            $data['companyId'] !== null ? new CompanyId($data['companyId']): null,
            new PriceRange(
                $data['price']['minPrice'],
                $data['price']['maxPrice']
            ),
            $data['address'],
            $data['active'],
            new DateTime()
        );

        $this->commandBus->dispatch($command);

        return $offerId;
    }
}
