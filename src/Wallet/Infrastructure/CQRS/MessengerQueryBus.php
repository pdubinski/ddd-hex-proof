<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\CQRS;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\HandleTrait;

final class MessengerQueryBus implements QueryBusInterface
{
    use HandleTrait {
        handle as handleQuery;
    }

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /** @return mixed */
    public function handle(QueryInterface $query)
    {
        return $this->handleQuery($query);
    }
}
