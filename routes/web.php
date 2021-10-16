<?php

use App\Http\Controllers\Coinbase\AccountsController;
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
    return redirect('/accounts');
});

Route::prefix('/accounts')->as('accounts.')->group(function () {
    Route::get('/', [AccountsController::class, 'index'])->name('index');
});
