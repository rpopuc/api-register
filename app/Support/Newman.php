<?php

namespace App\Support;

use GuzzleHttp\Client as HttpClient;

class Newman
{
    /**
     * @var string
     */
    private $urlBase;

    public function __construct(HttpClient $httpClient)
    {
        $this->urlBase = config('services.newman.url');
        $this->httpClient = $httpClient;
    }

    public function run(string $providerId, string $consumerId): array
    {
        if (!$this->urlBase) {
            throw new \Exception('Newman URL is not defined');
        }

        if ($response = $this->httpClient->get("$this->urlBase/{$providerId}/{$consumerId}")) {
            return json_decode($response->getBody()->getContents(), true);
        }

        return [];
    }
}