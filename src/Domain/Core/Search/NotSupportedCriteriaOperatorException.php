<?php

namespace App\Domain\Core\Search;

use Symfony\Component\HttpKernel\Exception\HttpException;

class NotSupportedCriteriaOperatorException extends HttpException
{
    public function __construct(string $message)
    {
        parent::__construct(400, $message);
    }
}
