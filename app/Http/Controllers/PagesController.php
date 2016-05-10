<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Auth;
use App\Artwork;
use DB;
//use Request;
use Response;
use Illuminate\Http\Request;

class PagesController extends Controller {

	//
	public function index()
	{
		return View::make('index');
	}

	public function gallery()
	{
		$artworks = Artwork::all();
		$artCount = Artwork::where('state', 0)->count();
		return View::make('gallery/index', compact('artworks', 'artCount'));
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

	public function gallerySearch(Request $request)
	{
		
		if ($request->has('keyword'))
		{
		//dd($request->input('keyword'));
		$SearchQuery = [
			0 => $request->input('keyword'),
			1 => $request->input('kunstenaar'),
			2 => $request->input('kleur'),
			3 => $request->input('onderwerp'),
			4 => $request->input('grootte'),
			5 => $request->input('materiaal'),
			6 => $request->input('techniek')
		];
        $NoSpace = trim($SearchQuery[0], ' ');
        $result = Artwork::where('title', 'like', '%'.$NoSpace.'%')->get();

        if ($SearchQuery[1]) {
        	$result = Artwork::and()->get();
        }

     		
		    return View::make('/gallery/search')->with('result', $result);
		} 
		else 
		{
			return Redirect::action('PagesController@gallery');
		}
	}
}
