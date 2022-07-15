<?php

namespace App\Infrastructure\User\ReadModel;

use App\Domain\Core\Id\CompanyId;
use App\Domain\Core\Id\UserId;

class UserView
{
    private UserId $userId;
    private string $firstName;
    private string $lastName;
    private string $email;
    private bool $isActive;
    private CompanyId $companyId;

}
