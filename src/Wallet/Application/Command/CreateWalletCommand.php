<?php

namespace App\Wallet\Application\Command;

use App\Wallet\Domain\ValueObject\WalletId;
use App\Wallet\Infrastructure\CQRS\CommandInterface;

class CreateWalletCommand implements CommandInterface
{
    public function __construct(private WalletId $id, private string $ownerId)
    {
    }

    public function getId(): WalletId
    {
        return $this->id;
    }

    public function getOwnerId(): string
    {
        return $this->ownerId;
    }
}
