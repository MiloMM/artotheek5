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
Route::get('/', 'PagesController@index');
Route::get('/gallery','PagesController@gallery');
Route::get('/artists' , 'PagesController@artists');
Route::get('/myprofile', 'PagesController@myprofile'); // Redirect to own user profile

Route::resource('users', 'UserController');
Route::resource('events', 'EventController');
Route::resource('news', 'NewsController');
Route::resource('artworks', 'ArtworkController');
Route::resource('tags','TagsController');

Route::get('json/news', 'JsonController@news');
Route::get('json/artworks', 'JsonController@artworks');
Route::get('json/archivedArtworks', 'JsonController@archivedArtworks');




Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
