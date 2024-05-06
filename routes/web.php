<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// # Rotte pubbliche
Route::get('/', [GuestDashboardController::class, 'index'])
  ->name('home');

// # Rotte protette
Route::middleware('auth')
  ->prefix('/admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
      ->name('dashboard');

    Route::post('/sponsorships/payment_page', function () {
      return view('admin.sponsorships.payment_page');
    })->name('sponsorships.payment_page');

    Route::resource('/apartments', ApartmentController::class);
    Route::resource('/sponsorships', SponsorshipController::class);
    Route::resource('/messages', MessageController::class);
    Route::resource('/visits', VisitController::class);
    Route::resource('/services', ServiceController::class);
  });

require __DIR__ . '/auth.php';
