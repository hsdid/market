<?php
declare(strict_types=1);

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\DeactivateOfferCommand;
use App\Application\Offer\Exception\AlreadyDeactivated;
use App\Application\Offer\Exception\OfferNotFoundException;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeactivateOfferCommandHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @throws AlreadyDeactivated
     * @throws OfferNotFoundException
     */
    public function __invoke(DeactivateOfferCommand $command)
    {
        $offer = $this->offerRepository->getById($command->getOfferId());

        if (!$offer->isActive()) {
            throw new AlreadyDeactivated();
        }

        $offer->deactivate();
        $this->offerRepository->save($offer);
    }
}
