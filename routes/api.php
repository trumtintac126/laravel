<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['prefix' => '/posts', 'as' => 'posts.'], function () {
    Route::get('/', 'PostController@index')->name('index');
    Route::post('/', 'PostController@store')->name('store');
    Route::get('/{id}', 'PostController@show')->name('show');
    Route::put('/', 'PostController@update')->name('update');
    Route::delete('/{id}', 'PostController@destroy')->name('destroy');
});


//login
//restful api user
Route::resource('users','Api\UserController');
// route get logout
Route::get('/logout', 'Api\UserController@logout');
// route get profile
Route::get('/profile', 'Api\UserController@profile');


//no login
// route post login
Route::post('/login', 'Api\UserController@login');
