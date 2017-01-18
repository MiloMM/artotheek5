<?php namespace App\Http\Middleware;

use Closure;
use App\filter;
use App\filter_optie;
use App\Artist;
use DB;

class GetGlobalData {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		view()->composer('*', function ($view)
		{
			/* Get all the filter items and unset the ones that don't belong to an artwork */
			$filterData = filter_optie::orderBy('naam')->get();
			$count = 0;
			
			foreach($filterData as $filterItem) {
				if ($filterItem->naam != 'Alle Categorieën' && $filterItem->naam != 'Alle Genres' && $filterItem->naam != 'Alle Technieken' && $filterItem->naam != 'Alle Materialen' && $filterItem->naam != 'Alle Kleuren') {

					switch ($filterItem->filter_id) {
						case 1:
							$whereColumn = 'category';
							break;
						case 2:
							$whereColumn = 'genre';
							break;
						case 3:
							$whereColumn = 'technique';
							break;
						case 4:
							$whereColumn = 'material';
							break;
						case 4:
							$whereColumn = 'colour';
							break;
						default:
							break;
					}
					
					$result = DB::table('artworks')->where($whereColumn, $filterItem->naam)->get();
					if(count($result) < 1) {
						unset($filterData[$count]);
					}
				}
				
				$count++;
			}
			
			/* Get all the artists and unset the ones that don't belong to an artwork */
			$artists = Artist::orderBy('name')->get();
			$count = 0;
			
			foreach($artists as $artist) {
				$result = DB::table('artworks')->where('artist', $artist->id)->get();
				if(count($result) < 1) {
					unset($artists[$count]);
				}
				$count++;
			}
			
			$newarray = array();
			foreach ($filterData as $filter)
			{
				$newarray[$filter->filter_id][$filter->naam] = $filter->naam;
			}

            view()->share(['newarray' => $newarray, 'artists' => $artists]);
        });
		return $next($request);
	}

}
