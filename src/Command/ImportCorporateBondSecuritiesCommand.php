<?php

namespace App\Command;

use DateTime;
use DateInterval;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

use App\Service\ImportManager;
use App\Repository\ImportRepository;

class ImportCorporateBondSecuritiesCommand extends Command
{
    protected static $defaultName = 'import:corporate-bond-securities';
    protected static $defaultDescription = 'Imports corporate bond security data from the ECB';

    public function __construct(ImportManager $importManager, ImportRepository $importRepository)
    {
        $this->importManager = $importManager;
        $this->importRepository = $importRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption('until', null, InputArgument::OPTIONAL, 'Import ECB data from 2017 to this date', 'now');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Import dumps before
        $until_date = new DateTime($input->getOption("until"));

        // Date we'll try to import
        $date = new DateTime();
        $date->setDate(2017, 6, 23);

        // Try to import ECB data from 2017 till now
        while($date < $until_date) {
            $import = $this->importRepository->findOneBy(['date' => $date]);
            $notice = 'Holdings from %s already imported';

            // If csv dump at date is not imported yet, import it now
            if( ! $import) {
                $notice = 'Importing holdings from %s';
                $this->importManager->importFromEcb($date);
            }

            $io->writeln(sprintf($notice, $date->format('d-m-Y')));

            // ECB exports every friday, so try to download next week
            $date->add(new DateInterval("P7D"));
        }


        $io->success(sprintf('All weekly ECB CSPP dumps imported until %s', $until_date->format('d-m-Y')));

        return Command::SUCCESS;
    }
}
