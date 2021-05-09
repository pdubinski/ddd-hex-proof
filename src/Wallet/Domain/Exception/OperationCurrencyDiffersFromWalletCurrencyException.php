<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

use Exception;

class OperationCurrencyDiffersFromWalletCurrencyException extends Exception
{
    protected $message = 'Operation currency differs from wallet currency';
}
