<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase;

use App\Application\Offer\Command\UpdateOfferCommand;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\OfferId;
use App\Domain\Offer\ValueObject\PriceRange;
use App\Domain\Core\Message\CommandBusInterface;
use Assert\AssertionFailedException;

class UpdateOfferUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws AssertionFailedException
     */
    public function execute(OfferId $offerId, array $data): OfferId
    {
        $command = new UpdateOfferCommand(
            $offerId,
            $data['title'],
            $data['description'],
            $data['companyId'] !== null ? new CompanyId($data['companyId']): null,
            new PriceRange(
                $data['price']['minPrice'],
                $data['price']['maxPrice']
            ),
            $data['address'],
            $data['active']
        );

        $this->commandBus->dispatch($command);

        return $offerId;
    }
}
