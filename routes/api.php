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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->prefix('platforms')->group(function () {
    Route::get('/', 'PlatformController@index');
    Route::get('/{id}', 'PlatformController@show')->where('id', '[0-9]+');
    Route::get('/paginate', 'PlatformController@paginate')->name('paginate');
    Route::post('/', 'PlatformController@store');
    Route::delete('/{id}', 'PlatformController@destroy');
    Route::put('/{id}', 'PlatformController@update');
});

Route::namespace('Api')->prefix('categories')->group(function () {
    Route::get('/', 'CategoryController@index');
    Route::get('/{id}', 'CategoryController@show')->where('id', '[0-9]+');
    Route::get('/platform/{id}', 'CategoryController@getByPlatformId')->where('id', '[0-9]+');
    Route::get('/paginate', 'CategoryController@paginate')->name('paginate');
    Route::post('/', 'CategoryController@store');
});



