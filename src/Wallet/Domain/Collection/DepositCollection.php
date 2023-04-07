<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Collection;

use App\Wallet\Domain\Entity\DepositEntity;

class DepositCollection
{
    private array $depositsIndexedByCurrency;

    private function __construct(?DepositEntity ...$deposits)
    {
        $this->depositsIndexedByCurrency = [];

        foreach ($deposits as $deposit) {
            $this->depositsIndexedByCurrency[$deposit->getCurrency()] = $deposit;
        }
    }

    public static function createEmpty(): self
    {
        return new self();
    }

    public function getDepositByCurrency(string $currency): ?DepositEntity
    {
        return $this->depositsIndexedByCurrency[$currency] ?? null;
    }

    public function addDeposit(DepositEntity $deposit): void
    {
        $this->depositsIndexedByCurrency[$deposit->getCurrency()] = $deposit;
    }
}
