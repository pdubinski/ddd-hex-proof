<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\Persistence\Repository;

use App\Wallet\Domain\Wallet;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

class WalletRepository extends AggregateRepository
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Wallet::class),
            new AggregateTranslator(),
            null,
            null,
            true
        );
    }

    public function save(Wallet $wallet): void
    {
        $this->saveAggregateRoot($wallet);
    }

    public function get(string $id): ?Wallet
    {
        return $this->getAggregateRoot($id);
    }
}
