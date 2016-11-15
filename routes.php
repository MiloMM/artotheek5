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
Route::get('/gallery', 'PagesController@gallery');
Route::get('/reservations', 'ReservationController@index');
Route::get('/artists' , 'ArtistController@index');
Route::get('/news' , 'NewsController@index');
Route::get('/myprofile', 'PagesController@myprofile'); // Redirect to own user profile

Route::get('artworks/archived', 'ArtworkController@showArchived');

Route::resource('users', 'UserController');
Route::resource('events', 'EventController');
Route::resource('news', 'NewsController');
Route::resource('artworks', 'ArtworkController');
Route::resource('tags', 'TagsController');
Route::resource('reservation', 'ReservationController');

Route::get('json/news', 'JsonController@news');
Route::get('json/artworks', 'JsonController@artworks');
Route::get('json/archivedArtworks', 'JsonController@archivedArtworks');

Route::get('/reservation/create/{id}', 'ReservationController@create');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('logout', array('uses' => 'UserController@Logout'));
