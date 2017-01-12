<?php namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Input;
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
												->orderBy('naam')
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
		
		$exists = DB::table('filter_opties')->where(['filter_id' => $request['filter_id'], 'naam' => $request['naam']])->get();
		
		if (count($exists) == 0) {
			$filter_options->filter_id = $request['filter_id'];
			$filter_options->naam = $request['naam'];
			$filter_options->save();
			
			return redirect()->route('filterIndex', [$request['filter_id']])->with('succesMsg', '<span class="glyphicon glyphicon-ok"></span> U heeft succesvol het item <strong>' . $request['naam'] . '</strong> toegevoegd');
		}
		else {
			return redirect()->route('filterIndex', [$request['filter_id']])->with('errorMsg', '<span class="glyphicon glyphicon-remove"></span> Dit item bestaat al onder dit filter.');
		}

		
	}

	public function edit($filter, $id)
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Administrator'])) {
			$filterItem = filter_optie::findOrFail($id);
			return View::make('filters/edit', compact('filterItem'));
		}
		else {
			return View::make('errors/' . HttpCode::Unauthorized);
		}
		die;
	}

	public function update($id)
	{
		$filterItem = filter_optie::findOrFail($id);
		$filterItemBefore = $filterItem->naam;
		
		$exists = DB::table('filter_opties')->where(['filter_id' => $filterItem->filter_id, 'naam' => Input::get('naam')])->get();
		
		if (count($exists) == 0) {
			$filterItem->naam = Input::get('naam');
			
			if ($filterItem->filter_id == 1) {
				$column = "category";
			}
			elseif ($filterItem->filter_id == 2) {
				$column = "genre";
			}
			elseif ($filterItem->filter_id == 3) {
				$column = "technique";
			}
			elseif ($filterItem->filter_id == 4) {
				$column = "material";
			}
			elseif ($filterItem->filter_id == 5) {
				$column = "colour";
			}
			
			if ($filterItem->save()) {
				Artwork::where($column, $filterItemBefore)->update([$column => $filterItem->naam]);
				
				return redirect('filters/' . $filterItem->filter_id)->with('succesMsg', '<span class="glyphicon glyphicon-ok"></span> Het item <b>'.$filterItemBefore.'</b> is succesvol gewijzigd naar <b>'.$filterItem->naam.'</b>.');
			}
			else {
				return redirect('filters/' . $filterItem->filter_id)->with('errorMsg', '<span class="glyphicon glyphicon-ok"></span> Er is helaas iets fout gegaan. Probeer het nog een keer.');
			}
		}
		else {
			return redirect()->route('filterIndex', [$filterItem->filter_id])->with('errorMsg', '<span class="glyphicon glyphicon-remove"></span> Dit item bestaat al onder dit filter.');
		}
	}

	public function delete($filter, $id)
	{
		if (filter_optie::destroy($id)) {
			return redirect('filters/' . $filter)->with('succesMsg', '<span class="glyphicon glyphicon-ok"></span> Het item is succesvol verwijderd.');
		}
		else {
			return redirect('filters/' . $filter)->with('errorMsg', '<span class="glyphicon glyphicon-ok"></span> Er is iets fout gegaan met het verwijderen. Probeer het nog een keer.');
		}
	}

}
