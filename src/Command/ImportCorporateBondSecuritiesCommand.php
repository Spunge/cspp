<?php

namespace App\Command;

use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\ImportManager;

class ImportCorporateBondSecuritiesCommand extends Command
{
    protected static $defaultName = 'import:corporate-bond-securities';
    protected static $defaultDescription = 'Imports corporate bond security data from the ECB';

    public function __construct(ImportManager $importManager)
    {
        $this->importManager = $importManager;

        parent::__construct();
    }

    private function import(DateTime $date): Void {
        
    }

    /*
    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }
     */

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $date = new DateTime();
        $date->setDate(2017, 6, 23);
        $io->writeln(sprintf('Importing %s', $date->format('d-m-Y')));

        //$this->importManager->create($date);

        /*
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
         */

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
