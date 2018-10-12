<?php

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

/*
	
Route::get('/users/{id}/{name}',function($ids , $asmo){
	return "hello that is my funking pullshit " . $ids . " asmk yabny ahoh " . $asmo;
});

Route::get('/', function () {
    return view('welcome');
    return view('post/index');
    return view('post.index');
});


*/

/* --------------  pages Routes ------------------------ */
Route::get('/' , 'PagesController@index');

// Route::get('about' , 'PagesController@about'); // this line and the next are simillar
Route::get('/about' , 'PagesController@about');

Route::get('/services' , 'PagesController@services');


/* --------------  posts Routes ------------------------ */

// Route::resource('/posts' , 'PostsController');  // this line and the next are simillar
Route::resource('posts' , 'PostsController');

//those two next lines has created automatically after running php artisan make:auth

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');



/* --------------  posts Routes ------------------------ */

