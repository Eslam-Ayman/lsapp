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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::group(['namespace'=>'Api'], function(){
Route::post('signin', 'Api\TestsController@index');
Route::group(['middleware'=>'auth:api'], function(){
	// Route::get('posts', 'Api\PostsController@index');/*->middleware('auth:api')*/
	// Route::get('posts/{id}', 'Api\PostsController@show');
	// you can type only rather than except if you need
	Route::resource('posts', 'Api\PostsController', ['except' => ['create', 'edit']]);
});
// });
