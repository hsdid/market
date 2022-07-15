<?php
declare(strict_types=1);
namespace App\Ui\Rest\Responder;

use FOS\RestBundle\View\View;

interface ErrorResponderInterface
{
    public function fromString(string $message, ?int $responseCode = null): View;
}