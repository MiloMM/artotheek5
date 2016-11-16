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
use App\Services\TagsHelper;

class PagesController extends Controller {

	//
	public function index()
	{
		$artworks = Artwork::where(['state' => 0])->orderBy('id', 'DESC')->take(12)->get();
		$artCount = Artwork::where('state', 0)->count();
		TagsHelper::addTagsToCollection($artworks);
		return View::make('index', compact('artworks', 'artCount'));
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

	public function gallerySearch(Request $request)
	{
		
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
		$result[0] = strlen($NoSpace);
		$result[1] = Artwork::where('title', 'like', '%'.$NoSpace.'%');

		if ($SearchQuery[1] != 'Alle Kunstenaars')
		{
			str_replace('+', ' ', $SearchQuery[1]);
			$result[1] = $result[1]->where('artist', '=', $SearchQuery[1]);
		}
		if ($SearchQuery[2] != 'Alle Kleuren')
		{
			str_replace('+', ' ', $SearchQuery[2]);
			$result[1] = $result[1]->where('colour', '=', $SearchQuery[2]);
		}
		if ($SearchQuery[3] != 'Alle Onderwerpen')
		{
			str_replace('+', ' ', $SearchQuery[3]);
			$result[1] = $result[1]->where('category', '=', $SearchQuery[3]);
		}
		if ($SearchQuery[4] != 'Alle Grootte')
		{
			str_replace('+', ' ', $SearchQuery[4]);
			$result[1] = $result[1]->where('size', '=', $SearchQuery[4]);
		}
		if ($SearchQuery[5] != 'Alle Materialen')
		{
			str_replace('+', ' ', $SearchQuery[5]);
			$result[1] = $result[1]->where('material', '=', $SearchQuery[5]);
		}
		if ($SearchQuery[6] != 'Alle Technieken')
		{
			str_replace('+', ' ', $SearchQuery[6]);
			$result[1] = $result[1]->where('technique', '=', $SearchQuery[6]);
		}

		$result[1] = $result[1]->get();

		return View::make('/gallery/search')->with('result', $result);
	}

	public function about()
	{
		return view('about/index');
	}
}
