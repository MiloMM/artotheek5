<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use Input;
use App\News;
use App\Http\Requests\NewsRequest;
use Response;

class NewsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = News::all();
		return View::make('news/index', compact('articles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('news/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(NewsRequest $request)
	{
		$input = Input::all();
		$tags = explode(',', $input['tags']);

		$slug = strtolower(implode('-', explode(' ', $input['title'])));

		if (News::where('slug', $slug)->first()) {
			return Response::json([0 => 'Deze titel is al gebruikt bij een ander artikel.'], 409);
		}

		$input['slug'] = $slug;

		$article = News::create($input);

		/**
		 * @todo Tagging is not working
		 */
		// foreach ($tags as $tag) {
		// 	$article->tag($tag);
		// }

		return [
			0 => 'Nieuws artikel aangemaakt, klik <a href="/news/' . $slug . '">hier</a> om het te bekijken.'
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
		$article = News::where('slug', $slug)->first();
		if ($article) {
			return View::make('news/show', compact('article'));
		} else {
			throw new \Exception('Article was not found in the database.');
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
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function update($slug)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function destroy($slug)
	{
		//
	}

}
