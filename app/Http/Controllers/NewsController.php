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
		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

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
		$article = News::where('slug', $slug)->first();
		if ($article) {
			return View::make('news/edit', compact('article'));
		} else {
			throw new \Exception('Article was not found in the database.');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(NewsRequest $request, $id)
	{
		$input = Input::all();

		if (isset($input['state'])) {
			$article = News::findOrFail($id);
			$article->update($input);
			return Response::json([ 0 => 'Dit artikel is gewijzigd!'], 200);
		} else {
			
			$tags = explode(',', $input['tags']);

			$slug = strtolower(implode('-', explode(' ', $input['title'])));

			if (News::where('slug', $slug)->first() && News::where('slug', $slug)->first()->id != $id) {
				return Response::json([0 => 'Deze titel is al gebruikt bij een ander artikel.'], 409);
			}

			$input['slug'] = $slug;

			$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
			$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

			$article = News::findOrFail($id);
			$article->update($input);

			return Response::json([ 0 => 'Dit artikel is gewijzigd!'], 200); // 200 = OK
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$article = News::findOrFail($id);
		$article->delete();
		return Response::json([], 200);
	}

}
