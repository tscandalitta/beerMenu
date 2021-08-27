<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Auth;
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


Route::get('/orders/real_time', [OrderController::class, 'realTime']);

Route::get('/tables', [TableController::class,'showTables']);
Route::get('/items', [HomeController::class, 'listItems'])->name('list-items');
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
