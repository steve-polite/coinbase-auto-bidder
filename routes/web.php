<?php

use App\Http\Controllers\Coinbase\AccountsController;
use App\Http\Controllers\Coinbase\HomepageController;
use App\Http\Controllers\Coinbase\OrdersController;
use App\Http\Controllers\SettingsController;
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

Route::get('/', [HomepageController::class, 'index'])->name('homepage.index');

Route::prefix('/accounts')->as('accounts.')->group(function () {
    Route::get('/', [AccountsController::class, 'index'])->name('index');
});

Route::prefix('/orders')->as('orders.')->group(function () {
    Route::get('/', [OrdersController::class, 'index'])->name('index');
});

Route::prefix('settings')->as('settings.')->group(function () {
    Route::match(['get', 'post'], '/', [SettingsController::class, 'index'])->name('index');
});
