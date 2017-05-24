<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Artist;
use App\Artwork;
use App\User;
Use Input;
use View;
use Auth;
use Illuminate\Http\Request;
use DB;

class ArtistController extends Controller {

	/* Get all artists and pass them to the view. */
	public function index()
	{
		$artists = 	Artist::orderBy('name', 'ASC')->get();
		foreach ($artists as $artist) {
			if ($artist->user_id != 0) {
				$userProfileSlug = User::where('id', $artist->user_id)->select('slug')->get();
				$artist->profileLink = "/users/" . $userProfileSlug[0]->slug;
			}
			else {
				$artist->profileLink = "/artists/show/" . $artist->id;
			}
		}

		return View::make('artists/index',compact('artists'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$users = User::orderBy('name')->select('id', 'name')->get();

			return View::make('artists/create', compact('users'));
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$artist = new Artist();
			$artist->name = Input::get('name');
			$artist->user_id = Input::get('user');
			$artist->save();
			return redirect('/artists');
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$artworks = Artwork::where('artist', $id)->orderBy('created_at')->get();
		$artist = Artist::where('id', $id)->first();

		return view('artists/show', compact('artworks', 'artist'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$artist = Artist::findOrFail($id);
			$users = User::orderBy('name')->select('id', 'name')->get();
			
			return View::make('artists/edit', compact('artist', 'users'));
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$artist = Artist::findOrFail($id);
			$artist->name = Input::get('name');
			$artist->user_id = Input::get('user');
			$artist->save();
			return redirect('/artists');
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

	/**
	 * Show the form for deleting an existing artist.
	 *
	 * @return Response
	 */
	public function delete($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$artist = Artist::findOrFail($id);

			return View::make('/artists/delete', compact('artist'));
		}
	}

	/**
	 * Remove the specified artist from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {

			$artist = Artist::findOrFail($id);
			if (Input::get('delete') == "delete") {
				$artist->delete();
			}
			elseif (Input::get('delete') == "deleteAll") {
				$artworks = Artwork::where('artist', $id)->delete();
				$artist->delete();
			}
			else {

			}
			return redirect('/artists');
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

}
