<?php
declare(strict_types=1);

namespace App\Application\Offer\UseCase\Photo;

use App\Application\Offer\Command\AddPhotoCommand;
use App\Domain\Core\Id\OfferId;
use App\Domain\Core\Message\CommandBusInterface;

class AddOfferPhotoUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(OfferId $offerId, array $data)
    {
        $this->commandBus->dispatch(AddPhotoCommand::withData($data, $offerId));
    }
}
