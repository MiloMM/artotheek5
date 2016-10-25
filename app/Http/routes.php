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
Route::get('/about', 'PagesController@about');

Route::get('/reservations', 'ReservationController@index');
Route::get('/artists' , 'PagesController@artists');
Route::get('/myprofile', 'PagesController@myprofile'); // Redirect to own user profile
Route::get('/gallery/search', 'PagesController@gallerySearch');

Route::get('gallery/archive', 'ArtworkController@showArchived');

Route::get('filters/{filter}/{id}/delete', 'FilterController@delete');
Route::get('filters/{filter}/{id}/edit', 'FilterController@edit');
Route::get('filters/{id}', ['as' => 'filterIndex', 'uses' => 'FilterController@index']);

Route::resource('filters', 'FilterController');
Route::resource('users', 'UserController');
Route::resource('events', 'EventController');
Route::resource('news', 'NewsController');
Route::resource('artworks', 'ArtworkController');
Route::resource('tags', 'TagsController');
Route::resource('reservation', 'ReservationController');

Route::get('/gallery', 'ArtworkController@index');
Route::get('artworks/{id}/archive', 'ArtworkController@archive');
Route::get('artworks/{id}/destroy', 'ArtworkController@destroy');

Route::get('json/news', 'JsonController@news');
Route::get('json/artworks', 'JsonController@artworks');
Route::get('json/archivedArtworks', 'JsonController@archivedArtworks');

Route::get('/reservation/create/{id}', 'ReservationController@create');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('logout', array('uses' => 'UserController@Logout'));