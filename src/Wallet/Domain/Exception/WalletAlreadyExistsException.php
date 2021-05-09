<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

use Exception;

class WalletAlreadyExistsException extends Exception
{
    protected $message = 'Wallet with this id already exists';
}
