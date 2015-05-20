<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class EventController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$events = Event::all();
		return view::make('events/index',compact($events));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view::make('events/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$tags = explode(',',$input['tags']);


		$slug = strtolower(implode('-',explode(' ',$input)));

		if(Events::where('slug',$slug)->first())
		{
			return Response::json([0=>'Dit Evenement is al aangemakt.'],409);
		}

		$input['slug'] = $slug;
		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$event = Events::create($input);

		return [
			0 => 'Nieuws artikel aangemaakt, klik <a href="/news/' . $slug . '">hier</a> om het te bekijken.'
		];
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$events = Events::where('slug',$slug)->first();
		if($events)
		{
			return view::make('events/show',compact($events));
		}
		else
		{
			throw new \Exeption('Evenement is niet gevonden in de database.');
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
			return view::make('events/edit',compact($event));
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
	public function update($id)
	{
		$input = Input::all();

		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$event = Events::findOrFail($id);
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
		$event = Events::findOrFail($id);
		$event->delete();
		return Response::json([],200);
	}

}
