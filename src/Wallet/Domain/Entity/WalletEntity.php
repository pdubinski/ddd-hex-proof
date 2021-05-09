<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\ValueObject\MoneyInterface;
use App\Wallet\Domain\ValueObject\WalletId;

class WalletEntity
{
    private WalletId $walletId;
    private string $ownerId;
    private MoneyInterface $balance;
    private string $currency;
    private WalletAssertion $assert;

    public function __construct(
        WalletId $walletId,
        string $ownerId,
        MoneyInterface $balance,
        string $currency
    ) {
        $this->walletId = $walletId;
        $this->ownerId = $ownerId;
        $this->balance = $balance;
        $this->currency = $currency;
        $this->assert = new WalletAssertion();
    }

    public function deposit(MoneyInterface $money): void
    {
        $this->balance = $this->balance->add($money);
    }

    public function withdraw(MoneyInterface $money): void
    {
        $this->assert
            ->assertSameCurrencyForOperation($this->balance, $money)
            ->assertEnoughFundsForWithdrawal($this->balance, $money);

        $this->balance = $this->balance->subtract($money);
    }

    public function getBalance(): MoneyInterface
    {
        return $this->balance;
    }
}
