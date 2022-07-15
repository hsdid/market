<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase;

use App\Application\Offer\Command\DeleteOfferCommand;
use App\Domain\Core\Message\CommandBusInterface;
use App\Domain\Offer\Offer;

class DeleteOfferUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(Offer $offer): void
    {
        $this->commandBus->dispatch(new DeleteOfferCommand($offer->getOfferId()));
    }
}
