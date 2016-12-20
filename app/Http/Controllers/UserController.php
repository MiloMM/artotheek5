<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\User;
use App\Artist;
use App\Artwork;
use Auth;
use View;
use Redirect;
use Input;
use Response;
use DB;

class UserController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$users['users'] = User::select('*', 'users.id as userId')->join('user_privelege', 'users.id', '=', 'user_privelege.user_id')->where('privelege_id', 1)->get();
			$users['artists'] = User::select('*', 'users.id as userId')->join('user_privelege', 'users.id', '=', 'user_privelege.user_id')->where('privelege_id', 2)->get();
			$users['administrators'] = User::select('*', 'users.id as userId')->join('user_privelege', 'users.id', '=', 'user_privelege.user_id')->where('privelege_id', 4)->get();
			//dd($users);
			return view('users/index', compact('users'));
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('users/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
			// Does this user exist?
			if (User::where('slug', $slug)->first())
			{
				// Check if the user is linked to an artist and get the artworks
				$user = User::where('slug',$slug)->first();
				$artist = Artist::where('user_id', $user->id)->first();
				
				if ($artist != null) {
					if ($artist->user_id != 0) {
						$artworks = Artwork::where('artist', $artist->id)->get();
					}
					else {
						$artworks = [];
					}
				}
				else {
					$artworks = [];
				}
				
				// Am i this user?
				if (Auth::check() && User::where('slug', $slug)->first()->id == Auth::user()->id)
				{
					return View::make('users/showself',compact('user', 'artworks'));
				}
				else {			
					return View::make('users/show', compact('user', 'artworks'));
				}
			}
			else
			{
				return Redirect::to('/');
			}
		}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function edit($slug)
	{
		if (Auth::check() && User::where('slug', $slug)->first()->id == Auth::user()->id || Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$user = User::where('slug',$slug)->first();
			
			$privelege = DB::table('user_privelege')->where('user_id', $user->id)->first();
			$user->privelege = ($privelege !== null) ? $privelege->privelege_id : 0;
			
			return View::make('users/edit',compact('user'));
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
	public function update($slug)
	{
		$user = User::where('slug',$slug)->first();
		$input = Input::all();

		$user->name = Input::get('name');
		$user->email = Input::get('email');
		$user->telephone = Input::get('telephone');
		$user->education = Input::get('education');
		$user->school_year = Input::get('school_year');
		$user->delivery_address = Input::get('delivery_address');
		$user->zip = Input::get('zip');
		
		$slug = strtolower(implode('-', explode(' ', Input::get('name'))));
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );
		
		$user->slug = $slug;
		
		$user->update();
		
		DB::table('user_privelege')->where('user_id', $user->id)->update(['privelege_id' => Input::get('privelege')]);

		return redirect('/users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$userPriveleges = DB::table('user_privelege')->where('user_id', '=', $id)->delete();
		$user = User::findOrFail($id);
		if ($artist = Artist::where('user_id', '=', $id)->first()) {
			$artist->user_id = 0;
			$artist->save();
		}
		$user->delete();
		return redirect()->action('UserController@index');
	}

	public function Logout()
	{
		Auth::logout();
    	return Redirect::to('auth/login');
	}
}
