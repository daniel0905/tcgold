<?php

use App\Http\Controllers\ParcelController;
use http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Route::prefix('/parcels')->namespace('Controllers')
//    ->group(function () {
//        Route::name('parcels.createParcel')
//            ->post('/', [ParcelController::class, 'createParcel']);
//        Route::name('parcels.getSingleParcel')
//            ->get('/{id}', [ParcelController::class, 'getSingleParcel'])->where('id', '[0-9]+');
//        Route::name('parcels.updateParcel')
//            ->put('/{id}', [ParcelController::class, 'updateParcel'])->where('id', '[0-9]+');
//        Route::name('parcels.deleteParcel')
//            ->delete('/{id}', [ParcelController::class, 'deleteParcel'])->where('id', '[0-9]+');
//    });
