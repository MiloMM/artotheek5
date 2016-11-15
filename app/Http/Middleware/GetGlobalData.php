<?php namespace App\Http\Middleware;

use Closure;
use App\filter;
use App\filter_optie;

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
			$filterData = filter_optie::orderBy('naam')->get();

			$newarray = array();
			foreach ($filterData as $filter)
			{
				$newarray[$filter->filter_id][$filter->naam] = $filter->naam;
			}

            view()->share('newarray', $newarray);
        });
		return $next($request);
	}

}
