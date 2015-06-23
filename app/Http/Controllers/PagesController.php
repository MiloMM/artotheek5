<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use Redirect;
use Auth;
use App\Artwork;
use DB;
use Response;

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
		if (Auth::check()) 
		{
			return Redirect::to('/users/' . Auth::user()->slug);
		} 
		else 
		{
			return Redirect::action('PagesController@index');
		}
	}

	public function artists()
	{
		$artists = 	DB::table('users')
	    ->join('user_privelege', function($join)
	    {
	        $join->on('users.id', '=', 'user_privelege.user_id')
	             ->where('user_privelege.privelege_id', '<', 3);
	    })
	    ->get();

		return View::make('artists/index',compact('artists'));
	}

}
