<?php
declare(strict_types=1);

namespace App\Application\Company\CommandHandler;

use App\Application\Company\Command\CreateCompanyCommand;
use App\Domain\Company\Company;
use App\Domain\Company\CompanyRepositoryInterface;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCompanyCommandHandler implements MessageHandlerInterface
{
    private CompanyRepositoryInterface $companyRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(CreateCompanyCommand $command)
    {
        $user = $this->userRepository->find($command->getUserId());
        $company = new Company(
            $command->getCompanyId(),
            $user,
            $command->getName(),
            $command->getDescription(),
            $command->getAddress(),
            $command->isActive(),
        );

        $this->companyRepository->save($company);
    }
}
