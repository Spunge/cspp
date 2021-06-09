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
use Symfony\Component\HttpClient\Exception\ClientException;

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

        $io->title(sprintf('Importing CSPP weekly holdings from %s to %s.', $date->format('d-m-Y'), $until_date->format('d-m-Y')));

        $interval = $until_date->diff($date);
        // Add progress bar
        $io->progressStart($interval->days / 7);

        // Try to import ECB data from 2017 till now
        while($date < $until_date) {
            $import = $this->importRepository->findOneBy(['date' => $date]);

            // If csv dump at date is not imported yet, import it now
            if( ! $import) {
                try {
                    $this->importManager->importFromEcb($date);
                } catch(ClientException $e) {
                    $io->newLine();
                    $io->note(sprintf('Exception occurred: %s', $e->getMessage()));
                }
            }

            // ECB exports every friday, so try to download next week
            $date->add(new DateInterval("P7D"));
            $io->progressAdvance();
        }

        $io->progressFinish();
        $io->success(sprintf('All weekly ECB CSPP dumps imported until %s', $until_date->format('d-m-Y')));

        return Command::SUCCESS;
    }
}
