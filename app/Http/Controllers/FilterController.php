<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Redirect;
use Auth;
use App\Artwork;
use DB;
//use Request;
use Response;
use Illuminate\Http\Request;
use App\filter;
use App\filter_optie;

class FilterController extends Controller
{

	public function index($id = 1)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) 
		{
			$filters = filter::all();
			$filter_opties = filter_optie::where('filter_id', '=', $id)
												->where('id', '>', 5)
												->get();

			return view::make('filters/index')->with(compact('filters', 'id', 'filter_opties', 'filter_count'));
		} 
		else
		{
			return View::make('errors/' . HttpCode::Unauthorized);
		}

	}

	public function store(request $request)
	{
		$filter_options = New filter_optie;

		$filter_options->filter_id = $request['filter_id'];
		$filter_options->naam = $request['naam'];
		$filter_options->save();

		return redirect()->route('filterIndex', [$request['filter_id']])->with('succesMsg', '<span class="glyphicon glyphicon-ok"></span> U heeft succesvol het item <strong>' . $request['naam'] . '</strong> toegevoegd');
	}
	
	public function edit()
	{
		echo 'response ='. $_POST['data'];
	}
	
	public function update()
	{
		
	}
	
	public function delete($filter, $id)
	{
		if (filter_optie::destroy($id)) {
			return redirect('filters/' . $filter)->with('errorMsg', '<span class="glyphicon glyphicon-ok"></span> Het item is succesvol verwijderd.');
		}
		else {
			return redirect('filters/' . $filter)->with('errorMsg', '<span class="glyphicon glyphicon-ok"></span> Er is iets fout gegaan met het verwijderen. Probeer het nog een keer.');
		}
	}

}