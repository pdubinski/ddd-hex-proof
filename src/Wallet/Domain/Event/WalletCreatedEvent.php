<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Event;

use Prooph\EventSourcing\AggregateChanged;

final class WalletCreatedEvent extends AggregateChanged
{
    public function ownerId(): string
    {
        return $this->payload()['ownerId'];
    }
}
