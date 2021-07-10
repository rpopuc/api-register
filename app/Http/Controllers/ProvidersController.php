<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Provider;
use Illuminate\Http\Request;

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
}
