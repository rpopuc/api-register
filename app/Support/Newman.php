<?php

namespace App\Support;

class Newman
{
    public function run(string $providerId, string $consumerId): array
    {
        $response = `node /var/www/html/node/index.js $providerId $consumerId`;

        return json_decode($response, true) ?? [];
    }
}