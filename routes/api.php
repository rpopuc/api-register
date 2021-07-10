<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumersController;
use App\Http\Controllers\ProvidersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function() {
    Route::post('/providers/{provider}/consumers', [ConsumersController::class, 'store'])->name('registerConsumer');
    Route::get('/providers/{provider}/consumers', [ProvidersController::class, 'consumers'])->name('listConsumers');

    Route::post('/providers', [ProvidersController::class, 'store'])->name('registerProvider');
   Route::get('/providers', [ProvidersController::class, 'index'])->name('listProviders');
   Route::get('/providers/{provider}.yaml', [ProvidersController::class, 'definition'])->name('getProviderDefinition');
   Route::get('/providers/{provider}', [ProvidersController::class, 'show'])->name('listProviders');

});