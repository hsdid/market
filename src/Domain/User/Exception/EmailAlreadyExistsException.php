<?php

namespace App\Domain\User\Exception;

class EmailAlreadyExistsException extends \Exception
{
    protected $message = 'User with such email already exists';

    public function getMessageKey(): string
    {
        return 'user.registration.email_exists';
    }

}