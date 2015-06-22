<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Event;

use View;
use Input;
use App\Http\Requests\EventRequest;
use Response;
use Auth;


class EventController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::where('state',0);
		return View::make('events/index',compact('events'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('events/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(EventRequest $request)
	{
		$input = Input::all();

		$slug = strtolower(implode('-',explode(' ',$input['title'])));
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );

		if(Event::where('slug',$slug)->first())
		{
			return Response::json([0=>'Dit Evenement is al aangemaakt.'],409);
		}
		
		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$input['slug'] = $slug;

		$event = Event::create($input);

		if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			$event->state = Input::get('publish') == "true" ? 0 : 1;
		} 	
		else
		{
			$event->state = 1;
		}

		$tags = explode(',',$input['tags']);
		foreach ($tags as $tag) 
		{
			$event->tag($tag);
		}

		return [
			0 => 'Evenement aangemaakt, klik <a href="/events/' . $slug . '">hier</a> om het te bekijken.'
		];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		$event = Event::where('slug',$slug)->first();

		$tagArray = $event->tagNames();

		if($event)
		{
			return View::make('events/show',compact('event','tagArray'));
		}
		else
		{
			throw new \Exception('Evenement is niet gevonden in de database.');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($slug)
	{
		$event = Event::where('slug',$slug)->first();

		if($event)
		{
			return View::make('events/edit',compact('event'));
		}
		else
		{
			throw new \Exception('Evenement is niet gevonden in de datbase');
		}


	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(EventRequest $request, $id)
	{
		$input = Input::all();

		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$slug = strtolower(implode('-',explode(' ',$input['title'])));
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );

		$event = Event::findOrFail($id);

		if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			$event->state = Input::get('publish') == "true" ? 0 : 1;
		} 
		else 
		{
			$event->state = 1;
		}

		$tags = explode(',', $input['tags']);
		foreach ($tags as $tag) 
		{
			$event->tag($tag);
		}

		$event->update(Input::all());

		return Response::json(['Evenement gewijzigd!'],200);
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	}
	public function destroy($id)
	{
		$event = Event::findOrFail($id);
		$event->delete();
		return Response::json([],200);
	}

}
