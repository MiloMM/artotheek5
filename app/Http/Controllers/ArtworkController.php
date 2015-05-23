<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use View;
use Input;
use App\Http\Requests\ArtworkRequest;
use Image;
use App\Artwork;
use Auth;

class ArtworkController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return 'Nothing to see here!';
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('artworks/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$artwork = new Artwork();
		$artwork->id = Artwork::count() + 1;
		$artwork->title = Input::get('title');
		$artwork->description = trim(Input::get('description'));
		$artwork->state = 0;


		$image = Image::make(Input::file('image'));
		$imageExtension = substr($image->mime(), 6);

		$artwork->file = 'images/artworks/' . $artwork->id . '.' . $imageExtension;
		/**
		 * @todo add middleware to check if logged in.
		 */
		$artwork->user_id = Auth::user()->id;

		$image->save('images/artworks/' . $artwork->id . '.' . $imageExtension);
		
		$artwork->save();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
