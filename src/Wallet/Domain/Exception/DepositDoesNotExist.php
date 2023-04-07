<?php

namespace App\Wallet\Domain\Exception;

use App\Wallet\Domain\ValueObject\WalletId;
use Exception;

class DepositDoesNotExist extends Exception
{
    public static function forCurrency(string $currency, WalletId $walletId)
    {
        return new self(
            sprintf(
                'Deposit for this currency and wallet does not exist (currency: %s, wallet id: %s)',
                $currency,
                $walletId->toString()
            )
        );
    }
}
