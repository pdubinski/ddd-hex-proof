<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\CQRS;

interface CommandBusInterface
{
    public function dispatch(CommandInterface $command): void;
}
