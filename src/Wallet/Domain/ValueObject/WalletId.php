<?php
declare(strict_types=1);

namespace App\Wallet\Domain\ValueObject;

use Symfony\Component\Uid\Uuid;

class WalletId
{
    private string $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function generate(): self
    {
        return new self(Uuid::v6()->toBase58());
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function toString(): string
    {
        return $this->id;
    }
}
