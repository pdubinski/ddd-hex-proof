<?php
declare(strict_types=1);
namespace App\Tests\unit\Wallet\Domain\Entity;

use App\Wallet\Domain\Entity\WalletEntity;
use App\Wallet\Domain\Exception\NotEnoughFundsForWithdrawalException;
use App\Wallet\Domain\Exception\OperationCurrencyDiffersFromWalletCurrencyException;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use PHPUnit\Framework\TestCase;

class WalletEntityTest extends TestCase
{
    public function testItIsNotPossibleToWithdrawMoreThanCurrentBalance()
    {
        $this->expectException(NotEnoughFundsForWithdrawalException::class);

        $currency = 'DOGE';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId',
            Money::create('1000', $currency),
            $currency
        );

        $amountToWithdraw = Money::create('9999', $currency);
        $walletEntity->withdraw($amountToWithdraw);
    }

    public function testItIsNotPossibleToWithdrawUsingDifferentCurrency()
    {
        $this->expectException(OperationCurrencyDiffersFromWalletCurrencyException::class);

        $currency = 'DOGE';
        $otherCurrency = 'ETH';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId',
            Money::create('1000', $currency),
            $currency
        );

        $amountToWithdraw = Money::create('500', $otherCurrency);
        $walletEntity->withdraw($amountToWithdraw);
    }

    public function testSuccessfulWithdrawal()
    {
        $currency = 'DOGE';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId',
            Money::create('1000', $currency),
            $currency
        );

        $amountToWithdraw = Money::create('600', $currency);
        $walletEntity->withdraw($amountToWithdraw);

        $this->assertEquals(400, $walletEntity->getBalance()->getAmount());
    }

    public function testSuccessfulDeposit()
    {
        $currency = 'DOGE';

        $walletEntity = new WalletEntity(
            WalletId::generate(),
            'ownerId',
            Money::create('0', $currency),
            $currency
        );

        $amountToDeposit = Money::create('600', $currency);
        $walletEntity->deposit($amountToDeposit);

        $this->assertEquals(600, $walletEntity->getBalance()->getAmount());
    }
}
