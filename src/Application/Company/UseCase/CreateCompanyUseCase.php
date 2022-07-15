<?php
declare(strict_types=1);
namespace App\Application\Company\UseCase;

use App\Application\Company\Command\CreateCompanyCommand;
use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\UserId;
use App\Domain\Core\Message\CommandBusInterface;
use Assert\AssertionFailedException;
use Symfony\Component\Uid\Uuid;

class CreateCompanyUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws AssertionFailedException
     */
    public function execute(string $userId, array $data): CompanyId
    {
        $companyId = new CompanyId((string) Uuid::v4());
        $command = new CreateCompanyCommand(
            $companyId,
            new UserId($userId),
            $data['name'],
            $data['description'],
            $data['address'] ?? null,
            $data['active']
        );

        $this->commandBus->dispatch($command);

        return $companyId;
    }
}
