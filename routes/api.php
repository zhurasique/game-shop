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

Route::get('categories', 'Api\CategoryController@index');
Route::get('categories/{id}', 'Api\CategoryController@show')->where('id', '[0-9]+');
Route::get('categories/paginate', 'Api\CategoryController@paginate')->name('paginate');

Route::get('platforms', 'Api\PlatformController@index');
Route::get('platforms/{id}', 'Api\PlatformController@show')->where('id', '[0-9]+');
Route::get('platforms/paginate', 'Api\PlatformController@paginate')->name('paginate');
Route::post('platforms', 'Api\PlatformController@store');
Route::delete('platforms/{id}', 'Api\PlatformController@destroy');
Route::put('platforms/{id}', 'Api\PlatformController@update');
