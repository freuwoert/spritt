<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\DriveController;
use App\Http\Controllers\PassengerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () { return redirect()->route('drives'); })->name('home');

Route::get('/drives', [DriveController::class, 'index'])->name('drives');
Route::post('/drives', [DriveController::class, 'store'])->name('drives.store');
Route::put('/drives/{drive}', [DriveController::class, 'update'])->name('drives.update');
Route::delete('/drives/{drive}', [DriveController::class, 'destroy'])->name('drives.destroy');

Route::get('/cars', [CarController::class, 'index'])->name('cars');
Route::post('/cars', [CarController::class, 'store'])->name('cars.store');
Route::put('/cars/{car}', [CarController::class, 'update'])->name('cars.update');
Route::delete('/cars/{car}', [CarController::class, 'destroy'])->name('cars.destroy');

Route::get('/passengers', [PassengerController::class, 'index'])->name('passengers');
Route::post('/passengers', [PassengerController::class, 'store'])->name('passengers.store');
Route::put('/passengers/{passenger}', [PassengerController::class, 'update'])->name('passengers.update');
Route::delete('/passengers/{passenger}', [PassengerController::class, 'destroy'])->name('passengers.destroy');