<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

use Exception;

class NotEnoughFundsForWithdrawalException extends Exception
{
    protected $message = 'Not enough funds for withdrawal';
}
