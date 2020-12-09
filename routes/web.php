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


route::GET('/games/{slug}','App\Http\Controllers\GamesController@show')->name('games.show');

route::GET('/','App\Http\Controllers\GamesController@index')->name('home');
