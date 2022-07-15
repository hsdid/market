<?php
declare(strict_types=1);

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\DeleteOfferCommand;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class DeleteOfferCommandHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;

    public function __construct(OfferRepositoryInterface $offerRepository)
    {
        $this->offerRepository = $offerRepository;
    }

    public function __invoke(DeleteOfferCommand $command)
    {
        $offer = $this->offerRepository->getById($command->getOfferId());
        $this->offerRepository->remove($offer);
    }
}
