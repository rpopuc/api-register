<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Consumer;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Support\OpenApiSpecification;

class ProvidersController extends Controller
{
    public function store(Request $request)
    {
        $provider = new Provider;
        $provider->fill($request->all());
        $provider->save();

        return response()->json($provider);
    }

    public function index(Request $request)
    {
        return Provider::all();
    }

    public function show(Provider $provider)
    {
        return $provider;
    }

    public function definition(Provider $provider)
    {
        return $provider->definition;
    }

    public function consumers(Provider $provider)
    {
        return Consumer::all();
        return Consumer::where('provider_id', $provider->id)->get();
    }

    public function testConsumer(Provider $provider, Consumer $consumer)
    {
        $client = new Client;
        $response = $client->get('http://newman:3000/test/example_provider/example_consumer');
        $summary = json_decode($response->getBody()->getContents());

        return response()->json([
            'provider' => $provider->id,
            'consumer' => $consumer->id,
            'summary' => $summary,
        ]);
    }

    public function test(Provider $provider, Consumer $consumer)
    {
        $httpClient = new Client;

        $consumers = Consumer::where('provider_id', $provider->id)->get();
        foreach ($consumers as $consumer) {
            $response = $httpClient->get("http://newman:3000/test/{$provider->id}/{$consumer->id}");
            $summaries[$consumer->id] = json_decode($response->getBody()->getContents());
        }

        return response()->json([
            'provider' => $provider->id,
            'consumer' => $consumer->id,
            'summaries' => $summaries ?? [],
        ]);
    }

    public function uris(Provider $provider)
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

        return response()->json($response ?? []);
    }
}
