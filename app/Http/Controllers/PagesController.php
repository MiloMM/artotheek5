<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Auth;
use App\Artwork;
use App\Artist;
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
			2 => $request->input('genre'),
			3 => $request->input('categorie'),
			4 => $request->input('grootte'),
			5 => $request->input('materiaal'),
			6 => $request->input('techniek')
		];

		$artworks = DB::table('artworks');
		
		if ($SearchQuery[0] != "")
		{
			$artworks = $artworks->where('title', 'like', '%'.$SearchQuery[0].'%');
			$tagResults = DB::table('artworks')->join('tagging_tagged', 'taggable_id', '=', 'artworks.id')->where('tag_name', 'like', '%'.$SearchQuery[0].'%')->groupBy('title');
		}
		if ($SearchQuery[1] != 'Alle Kunstenaars')
		{
			$artworks = $artworks->where('artist', '=', $SearchQuery[1]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('artist', '=', $SearchQuery[1]);
			}
		}
		if ($SearchQuery[2] != 'Alle Genres')
		{
			$artworks = $artworks->where('genre', '=', $SearchQuery[2]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('genre', '=', $SearchQuery[2]);
			}
		}
		if ($SearchQuery[3] != 'Alle Categorieën')
		{
			$artworks = $artworks->where('category', '=', $SearchQuery[3]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('category', '=', $SearchQuery[3]);
			}
		}
		if ($SearchQuery[4] != 'Alle Grootte')
		{
			$artworks = $artworks->where('size', '=', $SearchQuery[4]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('size', '=', $SearchQuery[4]);
			}
		}
		if ($SearchQuery[5] != 'Alle Materialen')
		{
			$artworks = $artworks->where('material', '=', $SearchQuery[5]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('material', '=', $SearchQuery[5]);
			}
		}
		if ($SearchQuery[6] != 'Alle Technieken')
		{
			$artworks = $artworks->where('technique', '=', $SearchQuery[6]);
			
			if (isset($tagResults)) {
				$tagResults = $tagResults->where('technique', '=', $SearchQuery[6]);
			}
		}
		
		if (isset($tagResults)) {
			$artworks = array_merge($artworks->get(), $tagResults->get());
		}
		else {
			$artworks = $artworks->get();
		}
		
		if (!empty($artworks)) {
			foreach ($artworks as $results) {
				$searchResults[$results->slug] = $results;
			}
			ksort($searchResults);
		}
		else {
			$searchResults = [];
		}
		
		if ($request->input('kunstenaar') != "Alle Kunstenaars") {
			$artist = Artist::select('name')->where('id', $request->input('kunstenaar'))->first()->toArray();
		}
		else {
			$artist['name'] = "Alle Kunstenaars";
		}
		
		return View::make('/gallery/search', compact('searchResults', 'request', 'artist'));
	}

	public function about()
	{
		return view('about/index');
	}
}
