<?php

use App\Http\Controllers\Api\ParcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/parcels')
    ->group(function () {
        Route::name('parcels.createParcel')
            ->post('/', [ParcelController::class, 'createParcel']);
        Route::name('parcels.getMultipleParcel')
            ->get('/', [ParcelController::class, 'getMultipleParcel']);
        Route::name('parcels.getSingleParcel')
            ->get('/{id}', [ParcelController::class, 'getSingleParcel'])->where('id', '[0-9]+');
        Route::name('parcels.updateParcel')
            ->put('/{id}', [ParcelController::class, 'updateParcel'])->where('id', '[0-9]+');
        Route::name('parcels.deleteParcel')
            ->delete('/{id}', [ParcelController::class, 'deleteParcel'])->where('id', '[0-9]+');
    });
