<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Event;

use View;
use Input;
use App\Http\Requests\EventRequest;
use Response;


class EventController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::all();
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
		$tags = explode(',',$input['tags']);


		$slug = strtolower(implode('-',explode(' ',$input['title'])));

		if(Event::where('slug',$slug)->first())
		{
			return Response::json([0=>'Dit Evenement is al aangemaakt.'],409);
		}

		$input['slug'] = $slug;
		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$event = Event::create($input);

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
		if($event)
		{
			return View::make('events/show',compact('event'));
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
	public function edit($id)
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

		$event = Event::findOrFail($id);
		$event->update(Input::all());
		return Response::json([],200);
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
