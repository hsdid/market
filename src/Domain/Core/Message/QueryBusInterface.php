<?php
declare(strict_types=1);
namespace App\Domain\Core\Message;

interface QueryBusInterface
{
    public function handle(QueryInterface $query);
}
