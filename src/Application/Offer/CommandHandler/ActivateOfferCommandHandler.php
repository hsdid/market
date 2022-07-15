<?php
declare(strict_types=1);

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\ActivateOfferCommand;
use App\Application\Offer\Exception\AlreadyActivated;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ActivateOfferCommandHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    /**
     * @throws AlreadyActivated
     */
    public function __invoke(ActivateOfferCommand $command)
    {
        $offer = $this->offerRepository->getById($command->getOfferId());

        if ($offer->isActive()) {
            throw new AlreadyActivated();
        }

        $offer->activate();

        $this->offerRepository->save($offer);
    }
}
