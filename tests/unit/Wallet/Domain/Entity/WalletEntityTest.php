<?php
declare(strict_types=1);
namespace App\Tests\unit\Wallet\Domain\Entity;

use App\Wallet\Domain\Entity\WalletEntity;
use App\Wallet\Domain\Exception\DepositDoesNotExist;
use App\Wallet\Domain\Exception\NotEnoughFundsForWithdrawalException;
use App\Wallet\Domain\Exception\OperationCurrencyDiffersFromWalletCurrencyException;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use PHPUnit\Framework\TestCase;

class WalletEntityTest extends TestCase
{
    public function testItIsNotPossibleToWithdrawMoreThanCurrentBalance(): void
    {
        $this->expectException(NotEnoughFundsForWithdrawalException::class);

        $currency = 'DOGE';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId'
        );

        $originalAmount = Money::create('1', $currency);
        $walletEntity->deposit($originalAmount);

        $amountToWithdraw = Money::create('9999', $currency);
        $walletEntity->withdraw($amountToWithdraw);
    }

    public function testItIsNotPossibleToWithdrawWhenDepositDoesNotExist(): void
    {
        $this->expectException(DepositDoesNotExist::class);

        $otherCurrency = 'ETH';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId'
        );

        $amountToWithdraw = Money::create('500', $otherCurrency);
        $walletEntity->withdraw($amountToWithdraw);
    }

    public function testSuccessfulWithdrawal(): void
    {
        $currency = 'DOGE';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId'
        );

        $originalAmount = Money::create('1000', $currency);
        $walletEntity->deposit($originalAmount);

        $amountToWithdraw = Money::create('600', $currency);
        $walletEntity->withdraw($amountToWithdraw);

        $this->assertEquals(
            400,
            $walletEntity->getDeposit($currency)->getBalance()->getAmount()
        );
    }

    public function testSuccessfulDeposit(): void
    {
        $currency = 'DOGE';
        $moneyToDeposit = 600;

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId'
        );

        $amountToDeposit = Money::create((string) $moneyToDeposit, $currency);
        $walletEntity->deposit($amountToDeposit);

        $this->assertEquals(
            $moneyToDeposit,
            $walletEntity->getDeposit($currency)->getBalance()->getAmount()
        );
    }
}
