<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/post', 'postController@post')->middleware('auth');

Route::get('/profile', 'profileController@profile')->middleware('auth');

Route::get('/category', 'categoryController@category')->middleware('auth');

Route::post('/addCategory', 'categoryController@addCategory')->middleware('auth');

Route::post('/addProfile', 'profileController@addProfile')->middleware('auth');

Route::post('/addPost', 'postController@addPost')->middleware('auth');

Route::get('/view/{id}', 'postController@view')->middleware('auth');

Route::get('/edit/{id}', 'postController@edit')->middleware('auth');

Route::post('/editPost/{id}', 'postController@editPost')->middleware('auth');

Route::get('/delete/{id}', 'postController@deletePost')->middleware('auth');

Route::get('/category/{id}', 'postController@category')->middleware('auth');

Route::get('/like/{id}', 'postController@like')->middleware('auth');

Route::get('/dislike/{id}', 'postController@dislike')->middleware('auth');

Route::post('/comment/{id}', 'postController@comment')->middleware('auth');

Route::post('/search', 'postController@search')->middleware('auth');

