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

            // Some securities returned by ECB only have ISIN & country set, so everything else is optional
            $security = $this->entityManager->getRepository(CorporateBondSecurity::class)
                ->findOneOrCreate(["isin" => $securityData['ISIN_CODE']]);

            // Set country when it exists
            if($securityData['NCB'] != "") {
                // Find or create country & corporation
                $country = $this->entityManager->getRepository(Country::class)
                    ->findOneOrCreate(["name" => $securityData['NCB']]);
                
                $security->setCountry($country);
            }

            // Set issuer when it exists
            if($securityData['ISSUER_NAME'] != "") {
                $corporation = $this->entityManager->getRepository(Corporation::class)
                    ->findOneOrCreate(["name" => $securityData['ISSUER_NAME']]);

                $security->setIssuer($corporation);
            }

            if($securityData['MATURITY_DATE'] != "") {
                $security->setMaturityDate(DateTime::createFromFormat('d/m/Y', $securityData['MATURITY_DATE']));
            }

            if($securityData['COUPON_RATE'] != "") {
                // When coupon rate is not numeric, it's a string like "floater" or "FLOATING" etc.
                // meaning this security has a variable interest rate
                // https://www.investopedia.com/terms/f/frn.asp
                $isFloating = ! is_numeric($securityData['COUPON_RATE']);

                $security->setIsFloating($isFloating);

                if( ! $isFloating) {
                    $float = (float) $securityData['COUPON_RATE'];

                    // TODO - there is some entries for which the rate changes somehow, this should be impossible
                    //$existing = $security->getCouponRate();
                    //if($existing !== null && $float != $existing) {
                        //var_dump($float, $existing);
                    //}

                    $security->setCouponRate($float);
                }
            }

            $this->entityManager->persist($security);

            $import->addCorporateBondSecurity($security);
        }

        $this->entityManager->flush();
    }
}
