<?php
declare(strict_types=1);

namespace App\Infrastructure\Core\Message;

use App\Domain\Core\Message\QueryBusInterface;
use App\Domain\Core\Message\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessageQueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /**
     * @param QueryInterface $query
     * @return mixed
     */
    public function handle(QueryInterface $query)
    {
        return $this->handleQuery($query);
    }
}
