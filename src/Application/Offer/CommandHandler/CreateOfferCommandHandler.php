<?php
declare(strict_types=1);

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\CreateOfferCommand;
use App\Application\Offer\Exception\CompanyNotBelongToUser;
use App\Application\Offer\Exception\CompanyNotFoundException;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Offer\Offer;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateOfferCommandHandler implements MessageHandlerInterface
{
    private OfferRepositoryInterface $offerRepository;
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(
        OfferRepositoryInterface $offerRepository,
        CompanyRepositoryInterface $companyRepository
    ) {
        $this->offerRepository = $offerRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * @throws CompanyNotFoundException
     * @throws CompanyNotBelongToUser
     */
    public function __invoke(CreateOfferCommand $command)
    {
        if ($command->getCompanyId()) {
            $company = $this->companyRepository->getById($command->getCompanyId());
            if (null === $company) {
                throw new CompanyNotFoundException();
            }
            if ((string) $company->getUser()->getId() !== (string) $command->getUserId()) {
                throw new CompanyNotBelongToUser();
            }
        }

        $offer = new Offer(
            $command->getOfferId(),
            $command->getUserId(),
            $command->getTitle(),
            $command->getDescription(),
            $company ?? null,
            $command->getPriceRange(),
            $command->getAddress(),
            $command->getCreatedAt(),
            $command->isActive(),
        );

        $this->offerRepository->save($offer);
    }
}
