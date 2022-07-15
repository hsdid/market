<?php

namespace App\Application\Offer\Exception;

class CompanyNotBelongToUser extends \Exception
{
    protected $message = 'Company not belong to user';
}