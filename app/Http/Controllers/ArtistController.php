<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Artist;
use App\User;
Use Input;
use View;
use Auth;
use Illuminate\Http\Request;
use DB;

class ArtistController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$artists = 	Artist::orderBy('name', 'ASC')->get();
		foreach ($artists as $artist) {
			if ($artist->user_id != 0) {
				$userProfileSlug = DB::table('users')->where('id', $artist->user_id)->select('slug')->get();
				$artist->profileLink = "/users/" . $userProfileSlug[0]->slug;
			}
			else {
				$artist->profileLink = "";
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
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) {
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
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) {
			$artist = new Artist();
			$artist->name = Input::get('name');
			$artist->user_id = Input::get('user');
			$artist->save();
			return redirect('/artists');
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
		die('Show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) {
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
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) {
			$artist = Artist::findOrFail($id);
			$artist->name = Input::get('name');
			$artist->user_id = Input::get('user');
			$artist->save();
			return redirect('/artists');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$artist = Artist::findOrFail($id);
		$artist->delete();
		return redirect('/artists');
	}

}
