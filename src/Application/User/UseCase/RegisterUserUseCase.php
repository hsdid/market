<?php

namespace App\Application\User\UseCase;

use App\Application\User\Command\RegisterUserCommand;
use App\Domain\Core\Id\UserId;
use App\Domain\Core\Message\CommandBusInterface;
use Assert\AssertionFailedException;
use Symfony\Component\Uid\Uuid;

class RegisterUserUseCase
{
    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @throws AssertionFailedException
     */
    public function execute(array $customerData): UserId
    {
        $userId = new UserId(Uuid::v4());
        $command = new RegisterUserCommand(
            $userId,
            $customerData['firstName'],
            $customerData['lastName'],
            $customerData['email'],
            $customerData['password'],
            true,
            new \DateTime()
        );

        $this->commandBus->dispatch($command);

        return $userId;
    }

}