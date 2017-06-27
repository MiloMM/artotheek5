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
Route::get('/conditions', 'PagesController@conditions');
Route::get('/users/destroy/{id}', 'UserController@destroy');
Route::get('/pagestext', 'PagesController@pagesText');
Route::post('/pagestextupdate', 'PagesController@updatePagesText');

Route::get('/artists' , 'ArtistController@index');
Route::get('/artists/show/{id}' , 'ArtistController@show');
Route::get('/artists/create' , 'ArtistController@create');
Route::get('/artists/edit/{id}' , 'ArtistController@edit');
Route::get('/artists/delete/{id}' , 'ArtistController@delete');

Route::get('/reservations', 'ReservationController@index');
Route::get('/myprofile', 'PagesController@myprofile'); // Redirect to own user profile
Route::get('/gallery/search', 'PagesController@gallerySearch');

Route::get('gallery/archive', 'ArtworkController@showArchived');

Route::get('filters/{filter}/{id}/delete', 'FilterController@delete');
Route::get('filters/{filter}/{id}/edit', 'FilterController@edit');
Route::get('filters/{id}', ['as' => 'filterIndex', 'uses' => 'FilterController@index']);

Route::resource('filters', 'FilterController');
Route::resource('artists', 'ArtistController');
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
Route::get('news/index', 'NewsController@index');
Route::get('news/create', 'NewsController@create');
Route::get('news/{slug}/edit', 'NewsController@index');
Route::get('news/article/{slug}', 'NewsController@show');

Route::get('reservation/create/{id}', 'ReservationController@create');
Route::get('reservation/show/{id}', 'ReservationController@show');
Route::get('reservation/edit/{id}','ReservationController@edit');
Route::get('reservation/destroy/{id}', 'ReservationController@destroy');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('logout', array('uses' => 'UserController@Logout'));
