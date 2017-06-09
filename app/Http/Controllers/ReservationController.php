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
use App\Reservation;
use DB;
use App\Http\Controllers\HttpCode;

class ReservationController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
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
				->get();

			return View::make('reservation/index')->with('reservations', $reservations);
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
	public function create($id)
	{
		if(Auth::check() && Auth::user()->hasOnePrivelege(['Administrator', 'Student'])) 
		{
			$artwork = Artwork::findOrFail($id);
			return View::make('reservation/create', compact('artwork'));
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$allReservations =	DB::table('reservations')
       	->where('artwork_id', '=', Input::get('artwork-id'))
       	->get();

		$reservation = new Reservation();

		$reservation->user_id = Auth::user()->id;
		$reservation->client = Input::get('client'); 
    	$reservation->company = Input::get('company'); 
		$reservation->artwork_id = Input::get('artwork-id');
		$reservation->from_date = Input::get('from-date');
		$reservation->to_date = Input::get('to-date');
		$reservation->delivery_adress = Input::get('delivery_adress');

		$artwork = Artwork::findOrFail(Input::get('artwork-id'));

		$overlap = false;
		foreach ($allReservations as $key) 
		{
			if (Input::get('from-date') < $key->to_date && Input::get('from-date') > $key->from_date)
			{
				$overlap = true;
			}
			elseif (Input::get('to-date') > $key->from_date && Input::get('to-date') < $key->to_date)
			{
				$overlap = true;
			}
			elseif (Input::get('from-date') == $key->from_date)
			{
				$overlap = true;
			}
		}

		if (!$overlap)
		{
			$artwork->reserved += 1;
			$reservation->save();
			$artwork->update(['reserved' => $artwork->reserved]);

			return Response::json([0 => 'Reservering geslaagd. Klik <a href="/gallery">hier</a> om terug te gaan'], HttpCode::Ok);
		}
		else
		{
			$latest = "";
			foreach ($allReservations as $key) 
			{
				if (is_null($latest))
				{
					$latest = $key->to_date;
				}
				elseif ($key->to_date > $latest)
				{
					$latest = $key->to_date;
				}
			}

			return Response::json([0 => 'Het kunstwerk is al gereserveerd op deze datum.'], HttpCode::Conflict);
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
