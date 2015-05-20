<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use Redirect;
use Auth;

class PagesController extends Controller {

	//
	public function index()
	{
		return View::make('index');
	}

	public function gallery()
	{
		return View::make('gallery/index');
	}

	public function myprofile()
	{
		if (Auth::check()) {
			return Redirect::to('/users/' . Auth::user()->slug);
		} else {
			return Redirect::action('PagesController@index');
		}
	}

}
