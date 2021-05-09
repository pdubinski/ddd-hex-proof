<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Event;

use Prooph\EventSourcing\AggregateChanged;

final class WithdrawMadeEvent extends AggregateChanged
{
    public function walletId(): string
    {
        return $this->payload()['walletId'];
    }

    public function amount(): string
    {
        return $this->payload()['amount'];
    }

    public function currency(): string
    {
        return $this->payload()['currency'];
    }
}
