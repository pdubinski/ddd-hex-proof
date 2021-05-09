<?php

namespace App\Wallet\Application\Command;

use App\Wallet\Domain\ValueObject\MoneyInterface;
use App\Wallet\Domain\ValueObject\WalletId;
use App\Wallet\Infrastructure\CQRS\CommandInterface;

class WithdrawCommand implements CommandInterface
{
    private WalletId $walletId;
    private MoneyInterface $amount;

    public function __construct(WalletId $walletId, MoneyInterface $amount)
    {
        $this->walletId = $walletId;
        $this->amount = $amount;
    }

    public function getWalletId(): WalletId
    {
        return $this->walletId;
    }

    public function getAmount(): MoneyInterface
    {
        return $this->amount;
    }
}
