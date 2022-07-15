<?php
declare(strict_types=1);
namespace App\Infrastructure\User\Service;

use App\Infrastructure\User\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    protected UserPasswordEncoderInterface $encoder;


    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    public function updatePassword(User $user): void
    {
        $password = $user->getPassword();

        if ($password !== null && 0 !== strlen($password)) {
            $user->setPassword($this->encoder->encodePassword($user, $password));
            $user->eraseCredentials();
        }
    }
}
