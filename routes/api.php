<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TableController;
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

Route::middleware('api')->get('/items', [ItemController::class,'index']);
Route::middleware('api')->post('/items', [ItemController::class,'store']);
Route::middleware('api')->put('/items/{item}', [ItemController::class,'update']);

Route::middleware('api')->get('/orders', [OrderController::class,'index']);
Route::middleware('api')->post('/orders', [OrderController::class,'store']);
Route::middleware('api')->put('/orders/{order}', [OrderController::class,'update']);
Route::middleware('api')->get('/orders/table/{table}', [OrderController::class,'ordersByTable']);

Route::middleware('api')->get('/tables', [TableController::class,'index']);
Route::middleware('api')->post('/tables', [TableController::class,'store']);


