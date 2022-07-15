<?php
declare(strict_types=1);

namespace App\Application\Offer\Exception;

use Exception;

class OfferNotFoundException extends Exception
{
    protected $message = 'Offer dose not exist';
}
