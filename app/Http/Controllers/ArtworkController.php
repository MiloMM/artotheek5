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
use Response;
use Redirect;
use Illuminate\Http\RedirectResponse;


class ArtworkController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::action('PagesController@gallery');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) {
			return View::make('artworks/create');
		} else {
			return View::make('errors/401'); // Unauthorized
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ArtworkRequest $request)
	{

		$artwork = new Artwork();
		$artwork->id = Artwork::count() + 1;
		$artwork->title = Input::get('title');
		$artwork->description = trim(Input::get('description'));
		$artwork->state = 0;

		$slug = strtolower(implode('-', explode(' ', Input::get('title'))));

		if (Artwork::where('slug', $slug)->first()) {
			return Response::json([0 => 'Deze titel is al gebruikt bij een ander kunstwerk.'], 409);
		}

		$artwork->slug = $slug;

		$image = Image::make(Input::get('image-data-url'));
		
		$imageExtension = substr($image->mime(), 6);

		$artwork->file = 'images/artworks/' . $artwork->id . '.' . $imageExtension;
		/**
		 * @todo add middleware to check if logged in.
		 */
		$artwork->user_id = Auth::user()->id;

		$image->save('images/artworks/' . $artwork->id . '.' . $imageExtension);
		
		$artwork->save();

		return Response::json([
			0 => 'Het kunstwerk is aangemaakt klik <a href="/artworks/' . $artwork->slug . '">hier</a> om het the bekijken'
		], 200);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$artwork = Artwork::whereSlug($slug)->first();
		if ($artwork) {
			return View::make('artworks/show')->with(compact('artwork'));
		} else {
			return View::make('errors/404');
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
		$artwork = Artwork::where('slug', $slug)->first();
		if ($artwork) {
			return View::make('artworks/edit', compact('artwork'));
		} else {
			throw new \Exception('Kunstwerk is niet gevonden in de database.');
		}

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function update(ArtworkRequest $request, $slug)
	{
		$input = Input::all();

		$input['description'] = str_replace("\n", '', $input['description']); // remove line endings
		$input['description'] = str_replace("\r", '', $input['description']); // remove line endings
		
		$artwork = Artwork::findOrFail($slug);
		$artwork->update(Input::all());
		
		return Response::json([], 200); // 200 = OK

		if (isset($input['state'])) {
			$artwork = Artwork::findOrFail($slug);
			$artwork->update($input);
			return Response::json([ 0 => 'Dit kunstwerk is gewijzigd!'], 200);
		} else {
			
			$tags = explode(',', $input['tags']);

			$slug = strtolower(implode('-', explode(' ', $input['title'])));

			if (Artwork::where('slug', $slug)->first() && Artwork::where('slug', $slug)->first()->slug != $slug) {
				return Response::json([0 => 'Deze titel is al gebruikt bij een ander kunstwerk.'], 409);
			}

			$input['slug'] = $slug;

			$input['description'] = str_replace("\n", '', $input['description']); // remove line endings
			$input['description'] = str_replace("\r", '', $input['description']); // remove line endings

			$artwork = Artwork::findOrFail($slug);
			$artwork->update($input);

			return Response::json([ 0 => 'Dit kunstwerk is gewijzigd!'], 200); // 200 = OK
		}
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */

	public function destroy($slug)
	{
		//
	}

}
