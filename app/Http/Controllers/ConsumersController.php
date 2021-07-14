<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Provider;
use Illuminate\Http\Request;

class ConsumersController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Provider $provider, Request $request)
    {
        $data = $request->all();
        $data['provider_id'] = $provider->id;

        $consumer = new Consumer;
        $consumer->fill($data);
        $consumer->save();

        return $consumer;
    }

    public function show(Provider $provider, Consumer $consumer)
    {
        return $consumer;
    }

    public function definition(Provider $provider, Consumer $consumer)
    {
        return $consumer->definition;
    }

    public function update(Request $request, Consumer $consumer)
    {
        //
    }

    public function destroy(Consumer $consumer)
    {
        //
    }
}
