<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/qrcode', function () {
    return QrCode::size(300)
        ->generate(env('APP_URL') . '/?table=' . request('id') . '&token=' . request('token'));
});

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});
