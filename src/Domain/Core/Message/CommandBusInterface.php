<?php
declare(strict_types=1);

namespace App\Domain\Core\Message;

interface CommandBusInterface
{
    public function dispatch(Command $command): void;
}