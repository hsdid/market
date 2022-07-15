<?php
declare(strict_types=1);
namespace App\Application\User\CommandHandler;

use App\Application\User\Command\RegisterUserCommand;
use App\Domain\User\Exception\EmailAlreadyExistsException;
use App\Domain\User\UserRepositoryInterface;
use App\Infrastructure\User\Entity\User;
use App\Infrastructure\User\Service\UserManager;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RegisterUserCommandHandler implements MessageHandlerInterface
{
    private UserRepositoryInterface $userRepository;
    private UserManager $userManager;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserManager $userManager
    ) {
        $this->userRepository = $userRepository;
        $this->userManager = $userManager;
    }

    /**
     * @throws EmailAlreadyExistsException
     */
    public function __invoke(RegisterUserCommand $command)
    {

        if (null !== $this->userRepository->findByEmail($command->getEmail())) {
            throw new EmailAlreadyExistsException();
        }

        $user = new User($command->getUserId());
        $user->setPassword($command->getPassword());
        $user->setEmail($command->getEmail());
        $user->setFirstName($command->getFirstName());
        $user->setLastName($command->getLastName());
        $this->userManager->updatePassword($user);

        $this->userRepository->save($user);
    }
}
