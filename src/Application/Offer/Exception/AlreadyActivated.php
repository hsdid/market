<?php
declare(strict_types=1);
namespace App\Application\Offer\Exception;

class AlreadyActivated extends \Exception
{
    public function __construct()
    {
        parent::__construct('offer already activeaaa');
    }
}
