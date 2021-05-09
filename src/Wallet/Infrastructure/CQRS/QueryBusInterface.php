<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\CQRS;

interface QueryBusInterface
{
    /**
     * @return mixed
     */
    public function handle(QueryInterface $query);
}
