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

use App\Service\Downloader;
use App\Service\ImportManager;

class ImportCorporateBondSecuritiesCommand extends Command
{
    protected static $defaultName = 'import:corporate-bond-securities';
    protected static $defaultDescription = 'Imports corporate bond security data from the ECB';

    public function __construct(ImportManager $importManager, Downloader $downloader)
    {
        $this->importManager = $importManager;
        $this->downloader = $downloader;

        parent::__construct();
    }

    // Before march 2020 there was only CSPP
    //https://www.ecb.europa.eu/mopo/pdf/CSPPholdings_20200327.csv
    // PEPP programme started in march 2020, so urls after 27 march 2020 use the following structure:
    //https://www.ecb.europa.eu/mopo/pdf/CSPP_PEPP_corporate_bond_holdings_20210604.csv
    private function getUrl(DateTime $date): String {
        $filename = "CSPPholdings_";
        if($date > new DateTime("2020-04-01")) {
            $filename = "CSPP_PEPP_corporate_bond_holdings_";
        }

        return sprintf("https://www.ecb.europa.eu/mopo/pdf/%s%s.csv", $filename, $date->format('Ymd'));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $date = new DateTime();
        $date->setDate(2017, 6, 23);

        while($date < new DateTime("now")) {
            $io->writeln(sprintf('Importing %s', $this->getUrl($date)));
            $date->add(new DateInterval("P7D"));
        }

        //$data = $this->downloader->download($url);
        //var_dump($data);

        //$this->importManager->create($date);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
