<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Support\ConsumerTest;
use App\Support\ProviderTest;
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
        return $provider->consumers;
    }

    public function testConsumer(Provider $provider, Consumer $consumer)
    {
        if (!$consumer->belongTo($provider)) {
            abort(404);
        }

        $consumerTest = app(ConsumerTest::class);

        return response()->json([
            'provider' => $provider->id,
            'summary' => $consumerTest->test($consumer),
        ]);
    }

    public function test(Provider $provider)
    {
        $providerTest = app(ProviderTest::class);

        $summaries = $providerTest->test($provider);

        return response()->json([
            'provider' => $provider->id,
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
