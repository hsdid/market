<?php
declare(strict_types=1);

namespace App\Application\Company\CommandHandler;

use App\Application\Company\Command\UpdateCompanyCommand;
use App\Domain\Company\CompanyRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateCompanyCommandHandler implements MessageHandlerInterface
{
    private CompanyRepositoryInterface $companyRepository;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function __invoke(UpdateCompanyCommand $command)
    {
        $company = $this->companyRepository->getById($command->getCompanyId());

        $company->setName($command->getName());
        $company->setDescription($command->getDescription());
        $company->setAddress($command->getAddress());
        $company->setActive($command->isActive());

        $this->companyRepository->save($company);
    }
}
