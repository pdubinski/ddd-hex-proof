<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Entity;

use App\Wallet\Domain\Collection\DepositCollection;
use App\Wallet\Domain\ValueObject\DepositId;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\MoneyInterface;
use App\Wallet\Domain\ValueObject\WalletId;

class WalletEntity
{
    private WalletAssertion $assert;
    private DepositCollection $deposits;

    public function __construct(
        private WalletId $walletId,
        private string $ownerId
    ) {
        $this->assert = new WalletAssertion();
        $this->deposits = DepositCollection::createEmpty();
    }

    public function deposit(MoneyInterface $money): void
    {
        $existingDeposit = $this->deposits->getDepositByCurrency($money->getCurrency());

        if (!$existingDeposit) {
            $existingDeposit = new DepositEntity(
                DepositId::generate(),
                $this->walletId,
                $money->getCurrency(),
                Money::create('0', $money->getCurrency())
            );
        }

        $existingDeposit->addMoney($money);
        $this->deposits->addDeposit($existingDeposit);
    }

    public function withdraw(MoneyInterface $money): void
    {
        $this->assert->assertDepositExists($this, $money)
            ->assertEnoughFundsForWithdrawal($this, $money);

        $existingDeposit = $this->deposits->getDepositByCurrency($money->getCurrency());
        $existingDeposit->subtractMoney($money);
        $this->deposits->addDeposit($existingDeposit);
    }

    public function hasDeposit(string $currency): bool
    {
        return null !== $this->deposits->getDepositByCurrency($currency);
    }

    public function getDeposit(string $currency): ?DepositEntity
    {
        return $this->deposits->getDepositByCurrency($currency);
    }

    public function getId(): WalletId
    {
        return $this->walletId;
    }
}
