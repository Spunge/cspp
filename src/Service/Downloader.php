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
                return $this->serializer->decode($content, 'csv');
                break;
            case "application/json":
                return $this->serializer->decode($content, 'json');
                break;
            default:
                throw new Exception('Unknown content type header');
        }
    }
}
