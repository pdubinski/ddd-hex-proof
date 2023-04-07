<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\ValueObject\DepositId;
use App\Wallet\Domain\ValueObject\MoneyInterface;
use App\Wallet\Domain\ValueObject\WalletId;

class DepositEntity
{
    public function __construct(
        private DepositId $id,
        private WalletId $walletId,
        private string $currency,
        private MoneyInterface $balance
    ) {
    }

    public function getCurrency(): string
    {
        return $this->balance->getCurrency();
    }

    public function getBalance(): MoneyInterface
    {
        return $this->balance;
    }

    public function setBalance(MoneyInterface $balance): void
    {
        $this->balance = $balance;
    }

    public function addMoney(MoneyInterface $money): void
    {
        $currentBalance = $this->balance;
        $this->setBalance($currentBalance->add($money));
    }

    public function subtractMoney(MoneyInterface $money): void
    {
        $currentBalance = $this->balance;
        $this->setBalance($currentBalance->subtract($money));
    }
}
