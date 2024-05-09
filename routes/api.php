<?php

use App\Http\Controllers\Api\ApartmentController;
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

Route::get('research/{lat}&{lon}&{radius}', [ApartmentController::class, 'research']);
Route::apiResource('apartments', ApartmentController::class)->only('index', 'show');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
