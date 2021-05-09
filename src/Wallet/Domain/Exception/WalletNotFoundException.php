<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

use Exception;

class WalletNotFoundException extends Exception
{
    protected $message = 'Wallet not found';
}
