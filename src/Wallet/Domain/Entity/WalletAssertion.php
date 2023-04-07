<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Exception\DepositDoesNotExist;
use App\Wallet\Domain\Exception\DepositWithThisCurrencyDoesNotExist;
use App\Wallet\Domain\Exception\NotEnoughFundsForWithdrawalException;
use App\Wallet\Domain\ValueObject\MoneyInterface;

class WalletAssertion
{
    public function assertEnoughFundsForWithdrawal(WalletEntity $wallet, MoneyInterface $money): self
    {
        $deposit = $wallet->getDeposit($money->getCurrency());

        if ($deposit->getBalance()->compare($money) < 0) {
            throw new NotEnoughFundsForWithdrawalException();
        }

        return $this;
    }

    public function assertDepositExists(WalletEntity $wallet, MoneyInterface $money): self
    {
        if (!$wallet->hasDeposit($money->getCurrency())) {
            throw DepositDoesNotExist::forCurrency($money->getCurrency(), $wallet->getId());
        }

        return $this;
    }
}
