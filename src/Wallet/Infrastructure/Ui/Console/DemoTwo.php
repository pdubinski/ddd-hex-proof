<?php
declare(strict_types=1);

namespace App\Wallet\Infrastructure\Ui\Console;

use App\Wallet\Application\Command\CreateWalletCommand;
use App\Wallet\Application\Command\WithdrawCommand;
use App\Wallet\Domain\ValueObject\Money;
use App\Wallet\Domain\ValueObject\WalletId;
use App\Wallet\Infrastructure\CQRS\CommandBusInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

class DemoTwo extends Command
{
    protected static $defaultName = 'app:demo:2';

    private CommandBusInterface $commandBus;

    public function __construct(CommandBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<fg=black;bg=green>DDD + Hexagonal Architecture + Prooph :: DEMO 2</>');
        $output->writeln('<fg=black;bg=green>create wallet, try to withdraw DOGE, you should get an error</>');

        $walletId = WalletId::generate();

        $this->commandBus->dispatch(
            new CreateWalletCommand(
                $walletId,
                Uuid::v6()->toBase58(),
                'DOGE'
            )
        );

        $output->writeln('<fg=green>1. wallet created</>');

        $output->writeln('<fg=green>2. try to withdraw 1000 DOGE</>');

        $this->commandBus->dispatch(
            new WithdrawCommand(
                $walletId,
                Money::create('1000', 'DOGE')
            )
        );

        return Command::SUCCESS;
    }
}
