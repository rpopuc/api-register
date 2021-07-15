<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumersController;
use App\Http\Controllers\ProvidersController;
use App\Models\Provider;
use App\Support\OpenApiSpecification;

Route::prefix('v1')->group(function() {
    Route::post('/providers/{provider}/consumers', [ConsumersController::class, 'store'])->name('registerConsumer');
    Route::get('/providers/{provider}/consumers/{consumer}.json', [ConsumersController::class, 'definition'])->name('getConsumerDefinition');
    Route::get('/providers/{provider}/consumers/{consumer}', [ConsumersController::class, 'show'])->name('showConsumer');
    //Route::put('/providers/{provider}/consumers/{consumer}', [ProvidersController::class, 'update'])->name('updateProvider');
    Route::get('/providers/{provider}/consumers', [ProvidersController::class, 'consumers'])->name('listConsumers');

    Route::post('/providers', [ProvidersController::class, 'store'])->name('registerProvider');
    //Route::put('/providers', [ProvidersController::class, 'update'])->name('updateProvider');
    Route::get('/providers', [ProvidersController::class, 'index'])->name('listProviders');
    Route::get('/providers/{provider}.yaml', [ProvidersController::class, 'definition'])->name('getProviderDefinition');
    Route::get('/providers/{provider}', [ProvidersController::class, 'show'])->name('listProviders');

    Route::get('/providers/{provider}/test', [ProvidersController::class, 'test'])->name('testProvider');
    Route::get('/providers/{provider}/consumers/{consumer}/test', [ProvidersController::class, 'testConsumer'])->name('testProviderForConsumer');

    Route::get('/providers/{provider}/uris', [ProvidersController::class, 'uris'])->name('urisFromProvider');
});

if (!app()->runningInConsole()) {
    foreach (Provider::all() as $provider) {
        $api = new OpenApiSpecification;
        $api->loadFromString($provider->definition);

        foreach ($api->getRoutes() as $route) {
            Route::match([$route->method], "v1/mock{$route->uri}", function () use ($api, $route) {
                return response()->json($api->createFrom($route->def['responses'][200]['schema']));
            });

            Route::match([$route->method], "v1/def{$route->uri}", function () use ($api, $route) {
                return response()->json($route->def);
            });
        }
    }
}