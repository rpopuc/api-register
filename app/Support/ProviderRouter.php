<?php

namespace App\Support;

use App\Models\Provider;
use App\Support\OpenApiSpecification;

class ProviderRouter
{
    public function getRoutes(Provider $provider): array
    {
        $api = new OpenApiSpecification;
        $api->loadFromString($provider->definition);

        foreach ($api->getRoutes() as $route) {
            $response[] = [
                'method' => $route->method,
                'uri' => $route->uri,
                'summary' => $route->def['summary'] ?? '',
                'description' => $route->def['description'] ?? '',
            ];
        }

        return $response ?? [];
    }
}