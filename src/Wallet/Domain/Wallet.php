<?php
declare(strict_types=1);

namespace App\Wallet\Domain;

use App\Wallet\Domain\Entity\WalletEntity;
use App\Wallet\Domain\Event\DepositMadeEvent;
use App\Wallet\Domain\Event\WalletCreatedEvent;
use App\Wallet\Domain\Event\WithdrawMadeEvent;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\MoneyInterface;
use App\Wallet\Domain\ValueObject\WalletId;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

class Wallet extends AggregateRoot
{
    private const INITIAL_BALANCE = '0';

    private WalletId $id;
    private WalletEntity $walletEntity;

    public static function createNew(string $id, string $ownerId): self
    {
        $wallet = new self();
        $wallet->recordThat(
            WalletCreatedEvent::occur($id, [
                'ownerId' => $ownerId,
            ])
        );

        return $wallet;
    }

    public function aggregateId(): string
    {
        return $this->id->toString();
    }

    protected function apply(AggregateChanged $event): void
    {
        if ($event instanceof WalletCreatedEvent) {
            $this->id = WalletId::fromString($event->aggregateId());

            $this->walletEntity = new WalletEntity(
                WalletId::fromString($event->aggregateId()),
                $event->ownerId()
            );
        }

        if ($event instanceof DepositMadeEvent) {
            $this->walletEntity->deposit(Money::create($event->amount(), $event->currency()));
        }

        if ($event instanceof WithdrawMadeEvent) {
            $this->walletEntity->withdraw(Money::create($event->amount(), $event->currency()));
        }
    }

    public function deposit(WalletId $walletId, MoneyInterface $amount): void
    {
        $this->recordThat(
            DepositMadeEvent::occur($walletId->toString(), [
                'amount' => $amount->getAmount(),
                'currency' => $amount->getCurrency(),
            ])
        );
    }

    public function withdraw(WalletId $walletId, MoneyInterface $amount): void
    {
        $this->recordThat(
            WithdrawMadeEvent::occur($walletId->toString(), [
                'amount' => $amount->getAmount(),
                'currency' => $amount->getCurrency(),
            ])
        );
    }
}
