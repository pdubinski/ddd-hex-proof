<?php

namespace App\Wallet\Application\Command;

use App\Wallet\Domain\ValueObject\WalletId;
use App\Wallet\Infrastructure\CQRS\CommandInterface;

class CreateWalletCommand implements CommandInterface
{
    private WalletId $id;
    private string $currency;
    private string $ownerId;

    public function __construct(WalletId $id, string $ownerId, string $currency)
    {
        $this->id = $id;
        $this->currency = $currency;
        $this->ownerId = $ownerId;
    }

    public function getId(): WalletId
    {
        return $this->id;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
