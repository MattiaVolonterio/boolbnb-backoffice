<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\ApartmentImageController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\Admin\VisitController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Guest\DashboardController as GuestDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

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
// Route::get('/', [GuestDashboardController::class, 'index'])
//   ->name('home');

// # Rotte pubbliche
Route::get('/', [AuthenticatedSessionController::class, 'create'])
  ->name('login');

// # Rotte protette
Route::middleware('auth')
  ->prefix('/admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
      ->name('dashboard');

    Route::resource('/apartments', ApartmentController::class);
    Route::resource('/sponsorships', SponsorshipController::class);
    Route::get('/messages/{apartment}', [MessageController::class, 'index'])->name('messages.index');
    Route::resource('/visits', VisitController::class);
    Route::resource('/services', ServiceController::class);
    Route::resource('/apartment-images', ApartmentImageController::class);
  });

require __DIR__ . '/auth.php';
