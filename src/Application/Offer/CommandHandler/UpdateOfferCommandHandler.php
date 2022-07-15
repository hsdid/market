<?php
declare(strict_types=1);

namespace App\Application\Offer\CommandHandler;

use App\Application\Offer\Command\UpdateOfferCommand;
use App\Application\Offer\Exception\CompanyNotBelongToUser;
use App\Application\Offer\Exception\CompanyNotFoundException;
use App\Application\Offer\Exception\OfferNotFoundException;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\Offer\OfferRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateOfferCommandHandler implements MessageHandlerInterface
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
     * @throws OfferNotFoundException
     */
    public function __invoke(UpdateOfferCommand $command)
    {
        $offer = $this->offerRepository->getById($command->getOfferId());

        if ($command->getCompanyId()) {
            $company = $this->companyRepository->getById($command->getCompanyId());
            if (null === $company) {
                throw new CompanyNotFoundException();
            }
            if ((string) $company->getUser()->getId() !== (string) $offer->getUserId()) {
                throw new  CompanyNotBelongToUser();
            }
        }

        $offer->setTitle($command->getTitle());
        $offer->setDescription($command->getDescription());
        $offer->setCompany($company ?? null);
        $offer->setPriceRange($command->getPriceRange());
        if ($command->isActive()) {
            $offer->activate();
        } else {
            $offer->deactivate();
        }

        $this->offerRepository->save($offer);
    }
}
