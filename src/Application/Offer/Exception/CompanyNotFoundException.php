<?php
declare(strict_types=1);

namespace App\Application\Offer\Exception;

use Exception;

class CompanyNotFoundException extends Exception
{
    protected $message = 'Company dose not exist';
}
