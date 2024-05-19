<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\MessageController;
use Doctrine\DBAL\Schema\Index;
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

Route::get('services', [ApartmentController::class, 'getServices']);
Route::get('research/{lat}&{lon}&{radius}', [ApartmentController::class, 'research']);
Route::get('research/{lat}&{lon}&{radius}/{n_room?}/{n_bathrooom?}/{n_bed?}/{square_meters?}/{floor?}/{services?}', [ApartmentController::class, 'filterApartments']);
// Route::get('apartments/sponsored', [ApartmentController::class, 'sponsoredApartments']); // Aggiunta nuova rotta per gli appartamenti sponsorizzati
Route::apiResource('apartments', ApartmentController::class)->only('index', 'show');
Route::apiResource('messages', MessageController::class)->only('store');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
