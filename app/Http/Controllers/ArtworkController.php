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
use App\Http\Controllers\HttpCode;
use DB;


class ArtworkController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// Show the gallery index
		return Redirect::action('PagesController@gallery');
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// Is the user a moderator or admin?
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			// Show the super create
			return View::make('artworks/create');
		} 
		// Is the user a student?
		else if (Auth::check() && Auth::user()->hasOnePrivelege(['Student'])) 
		{
			// Show the student version of the create
			return View::make('artworks/studentCreate');
		} 
		else
		{
			// Show the unauthorized page
			return View::make('errors/' . HttpCode::Unauthorized); // Unauthorized
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// Is the user a student or moderator or admin?
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Student', 'Moderator', 'Administrator'])) 
		{
			// Get all post data
			$input = Input::all();
			// Create an artwork
			$artwork = new Artwork();
			// Set the id one higher than the amount of artworks
			$artwork->id = Artwork::count() + 1;
			// Set the title to the input
			$artwork->title = Input::get('title');
			// Set the description to a trimmed version of the input (removing whitespaces)
			$artwork->description = trim(Input::get('description'));
			// Set the reserved to 0
			$artwork->reserved = 0;

			$artwork->artist = Input::get('artist');
			$artwork->technique = Input::get('technique');
			$artwork->category = Input::get('category');
			$artwork->size = Input::get('size');
			$artwork->price = Input::get('price');


			// get the tags [test,mark] <-- format and split them by a , to an array
			$tags = explode(',', $input['tags']);

			// Is the user an moderator or admin
			if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
			{
				// If the publish checkbox was checked set publish to true
				$artwork->state = Input::get('publish') == "true" ? 0 : 1;
			} 
			else
			{
				// Else make it archived
				$artwork->state = 1;
			}

			// Create a slug from the title
			// replace all spaces by a -
			$slug = strtolower(implode('-', explode(' ', Input::get('title'))));
			// replace all ?, /, \\ by nothing
			$slug = str_replace('?','', $slug);
			$slug = str_replace('/','',$slug );
			$slug = str_replace('\\','',$slug );

			// check if the slug already exist.
			if (Artwork::where('slug', $slug)->first()) 
			{
				// Tell the user this title is already being used
				return Response::json([0 => 'Deze titel is al gebruikt bij een ander kunstwerk.'], HttpCode::Conflict);
			}

			// Set the slug to the slug we created
			$artwork->slug = $slug;

			$image = Image::canvas(800, 600);
			$img = Image::make(Input::get('image-data-url'))->resize(800,600, function($c)
			{
				$c->aspectRatio();
    			$c->upsize();
			});
			$image->insert($img, 'center');

			// Retrieve the image
			$image = Image::make(Input::get('image-data-url'));
			
			// Get the image extension ex: png, jpg
			$imageExtension = substr($image->mime(), 6);

			$artwork->file = 'images/artworks/' . $artwork->id . '.jpeg' /*. $imageExtension*/;
			// set the image file to images/artworks/artwork number.extension
			$artwork->file = 'images/artworks/' . $artwork->id . '.' . $imageExtension;
			/**
			 * @todo add middleware to check if logged in.
			 */
			$artwork->user_id = Auth::user()->id;

			$image->save('images/artworks/' . $artwork->id . '.jpeg' /*. $imageExtension*/);
			// save it at the files place
			$image->save($artwork->file);

			// tag the artwork with all the tags
			foreach ($tags as $tag) 
			{
				$artwork->tag($tag);
			}

			// save the artwork data in the database
			$artwork->save();

			// Success
			return Response::json([
				0 => 'Het kunstwerk is aangemaakt klik <a href="/artworks/' . $artwork->slug . '">hier</a> om het the bekijken',
				1 => 'of klik <a href="/gallery"> hier </a> om terug te keren naar de gallerij'
			], 200);
		} 
		else 
		{
			// Unauthorized error
			return Response::json([
				0 => 'Je bent niet geautoriseerd.'
			], 401);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		// get the artwork by the slug
		$artwork = Artwork::whereSlug($slug)->first();

		$tagArray = $artwork->tagNames();

		$reservations =	DB::table('reservations')
        ->join('artworks', function($join)
        {
            $join->on('reservations.artwork_id', '=', 'artworks.id')
                 ->where('artworks.reserved', '>', 0);
        })
        ->join('users', function($join)
        {
            $join->on('reservations.user_id', '=', 'users.id');
        })
        ->select(['*', DB::raw('users.slug as userSlug'), DB::raw('artworks.slug as artworkSlug'),
        			   DB::raw('artworks.id as artworkId'), DB::raw('users.id as userId'),
        			   DB::raw('reservations.id as reservationId')])
        ->where('artworks.id','=',$artwork->id)
        ->get();

		if ($artwork) 
		{
			$tagArray = $artwork->tagNames();

			return View::make('artworks/show')->with(compact('artwork','tagArray','reservations'));
			// get the tags
		}
		else 
		{
			// Show a not found page
			return View::make('errors/' . HttpCode::NotFound);
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
		// get the artwork
		$artwork = Artwork::where('slug', $slug)->first();

		// Does the artwork exist?
		if ($artwork) 
		{
			// Show the view
			return View::make('artworks/edit', compact('artwork'));
		} 
		else 
		{
			// Show the not found page
			return View::make('errors/' . HttpCode::NotFound);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function update($id)
	{
		// Get our artwork
		$artwork = Artwork::findOrFail($id);

		// get all post data
		$input = Input::all();

		// Remove line endings from our description
		$input['description'] = str_replace("\n", '', $input['description']); // remove line endings
		$input['description'] = str_replace("\r", '', $input['description']); // remove line endings
		
		// make an tag array from the string
		$tags = explode(',', $input['tags']);

		// Make the title to a slug form
		$slug = strtolower(implode('-', explode(' ', Input::get('title'))));
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );

		// Set the slug
		$artwork->slug = $slug;

		$image = Image::canvas(800, 600);
			$img = Image::make(Input::get('image-data-url'))->resize(800,600, function($c)
			{
				$c->aspectRatio();
    			$c->upsize();
			});
			$image->insert($img, 'center');
		// Get the image
		$image = Image::make(Input::get('image-data-url'));
			
		// Get the extension ex: png, jpg
		$imageExtension = substr($image->mime(), 6);

		// Set the file
		$artwork->file = 'images/artworks/' . $artwork->id . '.' . $imageExtension;
		$artwork->user_id = Auth::user()->id;
		
		// Save the image
		$image->save($artwork->file);

		// Is the user a moderator or admin?
		if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			// If the checkbox is checked publish immediately
			$artwork->state = Input::get('publish') == "true" ? 0 : 1;
		} 
		else 
		{
			// Set to state to archived
			$artwork->state = 1;
		}

		// Tag our artwork with the tags given
		foreach ($tags as $tag) 
		{
			$artwork->tag($tag);
		}
		
		// Save our artwork
		$artwork->save();
		$artwork->update($input);	

		return Response::json(['Het kunstwerk is gewijzigd. klik <a href="/gallery">hier</a> om terug te keren naar de gallerij'], 200); // 200 = OK
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $id
	 * @return Response
	 */

	public function destroy($id)
	{
		//
	}

	/**
	 * @return string Response
	 */
	public function showArchived()
	{
		return Response::json(['test']);
	}
}
