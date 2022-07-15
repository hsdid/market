<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase;

use App\Application\Offer\Command\ActivateOfferCommand;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Message\CommandBusInterface;

class ActivateOfferUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(OfferId $offerId): void
    {
        $this->commandBus->dispatch(new ActivateOfferCommand($offerId));
    }
}
