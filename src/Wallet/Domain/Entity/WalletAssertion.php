<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Exception\NotEnoughFundsForWithdrawalException;
use App\Wallet\Domain\Exception\OperationCurrencyDiffersFromWalletCurrencyException;
use App\Wallet\Domain\ValueObject\MoneyInterface;

class WalletAssertion
{
    public function assertEnoughFundsForWithdrawal(MoneyInterface $currentBalance, MoneyInterface $money): self
    {
        if ($currentBalance->compare($money) < 0) {
            throw new NotEnoughFundsForWithdrawalException();
        }

        return $this;
    }

    public function assertSameCurrencyForOperation(MoneyInterface $currentBalance, MoneyInterface $money): self
    {
        if ($currentBalance->getCurrency() !== $money->getCurrency()) {
            throw new OperationCurrencyDiffersFromWalletCurrencyException();
        }

        return $this;
    }
}
