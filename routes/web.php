<?php

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->name('quote.')->prefix('quote')->group( function () {
  Route::post('/add', [\App\Http\Controllers\QuoteController::class, 'quote_add'])->name('add');
  Route::post('/edit', [\App\Http\Controllers\QuoteController::class, 'quote_edit'])->name('edit');
  Route::post('/add', [\App\Http\Controllers\QuoteController::class, 'quote_add'])->name('add');
});
