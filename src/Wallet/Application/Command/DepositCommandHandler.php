<?php

namespace App\Wallet\Application\Command;

use App\Wallet\Domain\Exception\WalletNotFoundException;
use App\Wallet\Infrastructure\CQRS\CommandHandlerInterface;
use App\Wallet\Infrastructure\Persistence\Repository\WalletRepository;

class DepositCommandHandler implements CommandHandlerInterface
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(DepositCommand $command): void
    {
        $aggregate = $this->walletRepository->get($command->getWalletId()->toString());

        if ($aggregate === null) {
            throw new WalletNotFoundException(
                sprintf('Wallet with id %s was not found', $command->getWalletId()->toString())
            );
        }

        $aggregate->deposit($command->getWalletId(), $command->getAmount());
        $this->walletRepository->saveAggregateRoot($aggregate);
    }
}
