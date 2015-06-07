<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use Redirect;
use Auth;
use App\Artwork;

class PagesController extends Controller {

	//
	public function index()
	{
		return View::make('index');
	}

	public function gallery()
	{
		$artworks = Artwork::all();
		$artCount = Artwork::where('state',0)->count();
		return View::make('gallery/index',compact('artworks','artCount'));
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
