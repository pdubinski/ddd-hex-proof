<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\Ui\Console;

use App\Wallet\Application\Command\CreateWalletCommand;
use App\Wallet\Application\Command\DepositCommand;
use App\Wallet\Application\Command\WithdrawCommand;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use App\Wallet\Infrastructure\CQRS\CommandBusInterface;
use App\Wallet\Infrastructure\Persistence\Repository\WalletRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'app:demo:1')]
class DemoOne extends Command
{
    private CommandBusInterface $commandBus;
    private WalletRepository $walletRepository;

    public function __construct(CommandBusInterface $commandBus, WalletRepository $walletRepository)
    {
        $this->commandBus = $commandBus;
        $this->walletRepository = $walletRepository;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=black;bg=green>DDD + Hexagonal Architecture + Prooph :: DEMO 1</>');
        $output->writeln('<fg=black;bg=green>create wallet, deposit some DOGE, withdraw DOGE</>');

        $walletId = WalletId::generate();

        $this->commandBus->dispatch(
            new CreateWalletCommand(
                $walletId,
                Uuid::v6()->toBase58()
            )
        );

        $output->writeln('<fg=green>1. wallet created</>');

        $this->commandBus->dispatch(
            new DepositCommand(
                $walletId,
                Money::create('10000', 'DOGE')
            )
        );

        $output->writeln('<fg=green>2. 10000 DOGE deposit</>');

        //$this->commandBus->dispatch(
        //    new WithdrawCommand(
        //        $walletId,
        //        Money::create('5000', 'DOGE')
        //    )
        //);

        $output->writeln('<fg=green>3. 5000 DOGE withdrawn</>');
        $output->writeln('');
        $output->writeln('<fg=green>Aggregate state:</>');

        $aggregateRoot = $this->walletRepository->get($walletId->toString());

        $output->writeln(var_export($aggregateRoot, true));

        return Command::SUCCESS;
    }
}
