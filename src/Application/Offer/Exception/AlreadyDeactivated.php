<?php

namespace App\Application\Offer\Exception;

class AlreadyDeactivated extends \Exception
{
    public function __construct()
    {
        parent::__construct('offer already inactive');
    }
}