<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Downloader
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
        $encoders = [new CsvEncoder(), new JsonEncoder()];
        $this->serializer = new Serializer([new ObjectNormalizer()], $encoders);
    }

    public function download($url): Array
    {
        $response = $this->client->request('GET', $url);

        $contentType = $response->getHeaders()['content-type'][0];
        $content = utf8_encode($response->getContent());

        switch($contentType) {
            case "text/csv":
                // ECB exports don't always return the same headers, so replace them.
                $lineBreak = strpos($content, "\n");
                $headers = "NCB,ISIN_CODE,ISSUER_NAME,MATURITY_DATE,COUPON_RATE\n";
                $content = $headers . substr($content, $lineBreak + 1);

                return $this->serializer->decode($content, 'csv');
            case "application/json":
                return $this->serializer->decode($content, 'json');
            default:
                throw new Exception('Unknown content type header');
        }
    }
}
