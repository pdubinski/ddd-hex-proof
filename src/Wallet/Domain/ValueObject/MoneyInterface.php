<?php
declare(strict_types=1);

namespace App\Wallet\Domain\ValueObject;

use Money\Money;

interface MoneyInterface
{
    public function getAmount(): string;
    public function getCurrency(): string;
    public function add(MoneyInterface ...$addendsAdapters): MoneyInterface;
    public function subtract(MoneyInterface ...$subtrahends): MoneyInterface;

    /**
     * Returns an integer less than, equal to, or greater than zero
     * if the value of this object is considered to be respectively
     * less than, equal to, or greater than the other.
     */
    public function compare(MoneyInterface $other): int;
}
