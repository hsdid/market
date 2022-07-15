<?php
declare(strict_types=1);

namespace App\Application\Company\UseCase;

use App\Application\Company\Command\UpdateCompanyCommand;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Message\CommandBusInterface;

class UpdateCompanyUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function execute(CompanyId $companyId, array $data): CompanyId
    {
        $command = new UpdateCompanyCommand(
            $companyId,
            $data['name'],
            $data['description'],
            $data['address'],
            $data['active']
        );

        $this->commandBus->dispatch($command);

        return $companyId;
    }
}
