<?php

namespace App\Service;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Import;
use App\Entity\Country;
use App\Entity\Corporation;
use App\Entity\CorporateBondSecurity;
use App\Service\Downloader;

class ImportManager
{
    public function __construct(EntityManagerInterface $entityManager, Downloader $downloader) {
        $this->entityManager = $entityManager;
        $this->downloader = $downloader;
    }

    private function getEcbDumpUrl(DateTime $date): String {
        // Before march 2020 there was only CSPP
        //https://www.ecb.europa.eu/mopo/pdf/CSPPholdings_20200327.csv
        // PEPP programme started in march 2020, so urls after 27 march 2020 use the following structure:
        //https://www.ecb.europa.eu/mopo/pdf/CSPP_PEPP_corporate_bond_holdings_20210604.csv
        $filename = $date > new DateTime("2020-04-01") ? "CSPP_PEPP_corporate_bond_holdings_" : "CSPPholdings_";

        return sprintf("https://www.ecb.europa.eu/mopo/pdf/%s%s.csv", $filename, $date->format('Ymd'));
    }

    /**
     * Import CSPP holdings CSV from ECB and import it
     */
    public function importFromEcb(DateTime $date) {
        // Download data from ECB
        $securitiesData = $this->downloader->download($this->getEcbDumpUrl($date));

        $import = new Import();
        $import->setDate($date);
        $this->entityManager->persist($import);
    
        foreach($securitiesData as $securityData) {
            // Don't import empty/invalid lines
            if( ! $securityData['ISIN_CODE']) {
                continue;
            }

            // Find or create country & corporation
            $country = $this->entityManager->getRepository(Country::class)
                ->findOneOrCreate(["name" => $securityData['NCB']]);
            $corporation = $this->entityManager->getRepository(Corporation::class)
                ->findOneOrCreate(["name" => $securityData['ISSUER_NAME_']]);

            // Find or create security
            $security = $this->entityManager->getRepository(CorporateBondSecurity::class)
                ->findOneBy(["isin" => $securityData['ISIN_CODE']]);

            if( ! $security) {
                $security = new CorporateBondSecurity();

                // Some of the ECB exports are weird
                $couponRate = array_key_exists('COUPON_RATE_*', $securityData) ? 'COUPON_RATE_*' : 'COUPON_RATE_';

                $security
                    ->setCountry($country)
                    ->setIssuer($corporation)
                    ->setIsin($securityData['ISIN_CODE'])
                    ->setMaturityDate(DateTime::createFromFormat('d/m/Y', $securityData['MATURITY_DATE_']))
                    ->setCouponRate((float) $securityData[$couponRate]);

                $this->entityManager->persist($security);
            }

            $import->addCorporateBondSecurity($security);
        }

        $this->entityManager->flush();
    }
}
