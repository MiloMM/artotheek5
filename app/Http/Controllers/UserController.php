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
		//var_dump(Input::all());
		$user->name = Input::get('name');
		if (!empty(Input::get('e-mail')) && !filter_var(Input::get('e-mail'), FILTER_VALIDATE_EMAIL) === false) {
			$user->email = Input::get('e-mail');
		}
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
		$user->biography = Input::get('biography');
		//var_dump($_FILES);
		if (!empty($_FILES['fileToUpload']['name'])) {
			/*if (!empty($user->profile_picture)) {
				unlink(substr($user->profile_picture, 1));
			}*/
			$target_dir = "images/users/";
			$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
			
			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
				$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				if($check !== false) {
					echo "File is an image - " . $check["mime"] . ".";
					$uploadOk = 1;
				} else {
					echo "File is not an image.";
					$uploadOk = 0;
				}
			}
			// Check if file already exists
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
				echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				$uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
				echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
					echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				} else {
					echo "Sorry, there was an error uploading your file.";
				}
			}
			
			$user->profile_picture = '/' . $target_file;
		}
		$user->update();

		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			DB::table('user_privelege')->where('user_id', $user->id)->update(['privelege_id' => Input::get('privelege')]);
			return redirect('/users');
		}
		else {
			return redirect('/myprofile');
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
