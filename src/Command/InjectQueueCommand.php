<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InjectQueueCommand extends Command
{
    protected static $defaultName = 'tritux:inject_queue';

    protected function configure()
    {
        $this
            ->setDescription('Inject message to queue safe arrival')
            ->addArgument('nmb_message', InputArgument::OPTIONAL, 'Message Number')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $nmb_message = $input->getArgument('nmb_message');

        if ($nmb_message) {
            $io->note(sprintf('You passed an argument: %s', $nmb_message));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
