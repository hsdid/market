<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase;

use App\Application\Offer\Command\DeactivateOfferCommand;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Message\CommandBusInterface;

class DeactivateOfferUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(OfferId $offerId): void
    {
        $this->commandBus->dispatch(new DeactivateOfferCommand($offerId));
    }
}
