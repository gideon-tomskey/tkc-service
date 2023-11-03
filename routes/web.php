<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CSVController;
use App\Http\Controllers\VideosCSVController;
use App\Http\Controllers\OrderRankingController;

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
    return view('welcome');
});

Route::get('/csv/convert', [CSVController::class, 'make_csv_form'])->name('csv-convert-form');
Route::post('/csv/convert', [CSVController::class, 'convert'])->name('csv-convert');
Route::get('/videos-csv/convert', [VideosCSVController::class, 'convert']);
Route::get('/order-rankings', [OrderRankingController::class, 'index']);
Route::get('/shopify/orders', [OrderRankingController::class,'getOrders'])->name('orders.index');