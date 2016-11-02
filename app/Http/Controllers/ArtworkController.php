<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\User;
use View;
use Input;
use App\Http\Requests\ArtworkRequest;
use Image;
use App\Artwork;
use App\filter;
use App\filter_optie;
use Auth;
use Response;
use Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\HttpCode;
use App\Services\TagsHelper;
use DB;


class ArtworkController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$artworks = Artwork::where(['state' => 0])->get()->reverse();
		$artCount = Artwork::where('state', 0)->count();
		TagsHelper::addTagsToCollection($artworks);
		return View::make('gallery/index', compact('artworks', 'artCount'));
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
			// Get the selectbox options and pass them to the view via the compact function.
			$artists = User::join('user_privelege', 'users.id', '=', 'user_privelege.user_id')->where('privelege_id', '=', 2)->get();
			//$artists = filter_optie::where('filter_id', '=', 1)->where('id', '>', 5)->orderBy('naam')->get();
			$techniques = filter_optie::where('filter_id', '=', 5)->where('id', '>', 5)->orderBy('naam')->get();
			$colours = filter_optie::where('filter_id', '=', 2)->where('id', '>', 5)->orderBy('naam')->get();
			$materials = filter_optie::where('filter_id', '=', 4)->where('id', '>', 5)->orderBy('naam')->get();
			$categories = filter_optie::where('filter_id', '=', 3)->where('id', '>', 5)->orderBy('naam')->get();
			$formats = array('Klein', 'Middelgroot', 'Groot');

			$filterArray = [
				'artists',
				'techniques',
				'colours',
				'materials',
				'categories',
				'formats'
			];

			// Show the super create
			return View::make('artworks/create', compact($filterArray));
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
			$artwork->id = Artwork::max('id') + 1;
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
			$artwork->colour = Input::get('colour');
			$artwork->material = Input::get('material');

			// get the tags [test,mark] <-- format and split them by a , to an array
			if (!empty($input['tags'])) {
				$tags = explode(',', $input['tags']);
			}


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
			if (!empty($tags)) {
				foreach ($tags as $tag)
				{
					$artwork->tag($tag);
				}
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
		$artist = User::where('users.id', '=', $artwork->artist)->first();
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

			return View::make('artworks/show')->with(compact('artwork','tagArray','reservations', 'artist'));
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
			// Get the selectbox options and pass them to the view via the compact function.
			$artists = User::join('user_privelege', 'users.id', '=', 'user_privelege.user_id')->where('privelege_id', '=', 2)->get();
			//$artists = filter_optie::where('filter_id', '=', 1)->where('id', '>', 5)->orderBy('naam')->get();
			$techniques = filter_optie::where('filter_id', '=', 5)->where('id', '>', 5)->orderBy('naam')->get();
			$colours = filter_optie::where('filter_id', '=', 2)->where('id', '>', 5)->orderBy('naam')->get();
			$materials = filter_optie::where('filter_id', '=', 4)->where('id', '>', 5)->orderBy('naam')->get();
			$categories = filter_optie::where('filter_id', '=', 3)->where('id', '>', 5)->orderBy('naam')->get();
			$formats = array('Klein', 'Middelgroot', 'Groot');

			$filterArray = [
				'artwork',
				'artists',
				'techniques',
				'colours',
				'materials',
				'categories',
				'formats'
			];

			// Show the view

			return View::make('artworks/edit', compact($filterArray));
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

		// Select the artwork you want to modify.
		$artwork = Artwork::find($id);
		// Check if you want to publish it.
		$publish = isset($_POST['publish']) ? 0 : 1;

		// Create a slug from the title
		// replace all spaces by a -
		$slug = strtolower(implode('-', explode(' ', Input::get('title'))));
		// replace all ?, /, \\ by nothing
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );

		if ($checkSlug = Artwork::where('slug', $slug)->first()) {
			if ($artwork->id !== $checkSlug->id) {
				return Response::json([0 => 'Deze titel is al gebruikt bij een ander kunstwerk.'], HttpCode::Conflict);
			}
		}
		// Update all the fields.
		$artwork->update([
			'title' => $_POST['title'],
			'description' => $_POST['description'],
			'artist' => $_POST['artist'],
			'technique' => $_POST['technique'],
			'colour' => $_POST['colour'],
			'material' => $_POST['material'],
			'category' => $_POST['category'],
			'size' => $_POST['size'],
			'price' => $_POST['price'],
			'state' => $publish,
			'slug' => $slug
		]);

		if (!empty(Input::get('old-tags'))) {
			$oldTags = explode(',', Input::get('old-tags'));
		}

		if (!empty(Input::get('tags'))) {
			$tags = explode(',', Input::get('tags'));
		}

		if (!empty($oldTags)) {
			DB::table('tagging_tagged')->where('taggable_id', $artwork->id)->delete();
		}

		// tag the artwork with all the tags
		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$artwork->tag($tag);
			}
		}

		$artwork->save();

		return redirect('artworks/'.$artwork->slug);
	}
	/* Delete the artwork from the archive (and so the database). */
	public function destroy($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
		{
			Artwork::destroy($id);
			return Redirect()->action('ArtworkController@showArchived');
		}
		else {
			return View::make('errors/' . HttpCode::NotFound);
		}
	}

	/* If the artwork is not yet in the archive, move it there. Otherwise remove it from the archive and put it back to the gallery. */
	public function archive($id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
		{
			$artwork = Artwork::findOrFail($id);
			if ($artwork->state === 0) {
				$artwork->state = 1;
				$artwork->save();
				return Redirect()->action('ArtworkController@showArchived');
			}
			else {
				$artwork->state = 0;
				$artwork->save();
				return Redirect()->action('ArtworkController@index');
			}
		}
		else {
			return View::make('errors/' . HttpCode::NotFound);
		}
	}

	/* Get all archived artworks and show them on the page. */
	public function showArchived()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator']))
		{
			$artworks = Artwork::where(['state' => 1])->get();
			$artCount = Artwork::where('state', 1)->count();
			TagsHelper::addTagsToCollection($artworks);
			return View::make('gallery/archive', compact('artworks', 'artCount'));
		}
		else {
			return View::make('errors/' . HttpCode::NotFound);
		}
	}
}
