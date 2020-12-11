<?php

use Illuminate\Http\Request;
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

Route::get('/quotes', function () {
  $quotes = \Illuminate\Support\Facades\DB::table('quotes')
    ->join('users', 'users.id', '=', 'quotes.author_id')
    ->select('quotes.text', 'users.name as author')->get();
  return response(['data'=>$quotes, 'status'=>'success']);
});

