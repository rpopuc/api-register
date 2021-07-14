<?php

namespace App\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;
use Illuminate\Filesystem\Filesystem;

class OpenApiSpecification
{
    public function loadFromFile(string $filename)
    {
        $fs = app(Filesystem::class);
        return $this->loadFromString($fs->get($filename));
    }

    public function loadFromString(string $yaml)
    {
        $this->definition = Yaml::parse($yaml, Yaml::PARSE_OBJECT);
        $this->routes = [];

        foreach ($this->definition['paths'] as $uri => $path) {
            foreach ($path as $method => $pathDef) {
                if ($method == 'get') {
                    // if ($pathDef['responses'][200] ?? false) {
                    //     $response = $this->createFrom($pathDef['responses'][200]['schema']);
                    //     dump($response);
                    // }
                }

                $this->routes[] = (object)[
                    'method' => $method,
                    'uri' => $uri,
                    'def' => $pathDef
                ];
            }
        }

        $this->routes = collect($this->routes);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function findRoute(string $method, string $uri)
    {
        return $this->routes->first(function($route) use ($method, $uri) {
            return $method == $route->method &&
                   $uri == $route->uri;
        });
    }

    public function createFrom($def)
    {
        switch ($def['type'] ?? null) {
            case 'array':
                $result = [];
                $max = rand(1, 10);
                for ($i = 1; $i <= $max; $i++) {
                    $result[] = $this->createFromDef($def['items']['$ref']);
                }
                return $result;
                break;

            case 'object':
                $result = new \stdClass();
                foreach ($def['properties'] as $property => $propertyDef) {
                    $result->$property = $this->createFrom($propertyDef);
                }
                return $result;
                break;

            case 'integer':
                return rand();
                break;

            case 'string':
                return Str::random(32);
                break;

            case 'boolean':
                return true;
                break;

            default:
                if ($reference = $def['$ref'] ?? false) {
                    return $this->createFromDef($reference);
                }
                break;
        }
    }

    public function createFromDef($defitionPath)
    {
        $path = str_replace(['/'], ['.'], trim($defitionPath, ' #/'));

        $definition = Arr::get($this->definition, $path);

        return $this->createFrom($definition);
    }
}