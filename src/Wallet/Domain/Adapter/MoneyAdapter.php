<?php
declare(strict_types=1);

namespace App\Wallet\Domain\Adapter;

use App\Wallet\Domain\ValueObject\MoneyInterface;
use Money\Currency;
use Money\Money as AdaptedMoney;

class MoneyAdapter implements MoneyInterface
{
    private AdaptedMoney $money;

    private function __construct()
    {
        // initialization through static methods only
    }

    public static function create(string $amount, string $currency): MoneyInterface
    {
        $self = new self();
        $self->money = new AdaptedMoney($amount, new Currency($currency));

        return $self;
    }

    private static function createFromMoney(AdaptedMoney $money): MoneyInterface
    {
        $self = new self();
        $self->money = $money;

        return $self;
    }

    public function getAmount(): string
    {
        return $this->money->getAmount();
    }

    public function getCurrency(): string
    {
        return $this->money->getCurrency()->getCode();
    }

    public function add(MoneyInterface ...$addendsAdapters): MoneyInterface
    {
        $adaptedMoney = $this->convertAdaptersToAdapted(...$addendsAdapters);
        $newMoney = $this->money->add(...$adaptedMoney);

        return self::createFromMoney($newMoney);
    }

    public function subtract(MoneyInterface ...$subtrahendsAdapters): MoneyInterface
    {
        $adaptedMoney = $this->convertAdaptersToAdapted(...$subtrahendsAdapters);
        $newMoney = $this->money->subtract(...$adaptedMoney);

        return self::createFromMoney($newMoney);
    }

    public function compare(MoneyInterface $other): int
    {
        $otherAdapted = new AdaptedMoney($other->getAmount(), new Currency($other->getCurrency()));
        return $this->money->compare($otherAdapted);
    }

    /**
     * @return array|AdaptedMoney[]
     */
    private function convertAdaptersToAdapted(MoneyInterface ...$adapters): array
    {
        $adapted = [];

        foreach ($adapters as $adapter) {
            $adapted[] = new AdaptedMoney($adapter->getAmount(), new Currency($adapter->getCurrency()));
        }

        return $adapted;
    }
}
