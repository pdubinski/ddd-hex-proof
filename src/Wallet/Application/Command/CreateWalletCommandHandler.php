<?php

namespace App\Wallet\Application\Command;

use App\Wallet\Domain\Exception\WalletAlreadyExistsException;
use App\Wallet\Domain\Wallet;
use App\Wallet\Infrastructure\CQRS\CommandHandlerInterface;
use App\Wallet\Infrastructure\Persistence\Repository\WalletRepository;

class CreateWalletCommandHandler implements CommandHandlerInterface
{
    private WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    public function __invoke(CreateWalletCommand $command): void
    {
        $wallet = $this->walletRepository->get($command->getId()->toString());

        if ($wallet instanceof Wallet) {
            throw new WalletAlreadyExistsException();
        }

        $wallet = Wallet::createNew(
            $command->getId()->toString(),
            $command->getOwnerId()
        );

        $this->walletRepository->saveAggregateRoot($wallet);
    }
}
