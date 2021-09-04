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


Route::get('/orders/real_time', [OrderController::class, 'realTime'])->name('real-time-orders');

Route::get('/tables', [TableController::class,'showTables'])->name('show-tables');
Route::get('/items', [HomeController::class, 'listItems'])->name('list-items');
Route::get('/items/create', [HomeController::class, 'createItem'])->name('create-items');
Route::get('/items/update/{item}', [HomeController::class, 'updateItem'])->name('update-item');
Route::get('/charts', [HomeController::class,'charts'])->name('show-charts');


Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
