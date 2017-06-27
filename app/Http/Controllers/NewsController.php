<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;
use Input;
use App\News;
use App\Http\Requests\NewsRequest;
use App\Http\Controllers\HttpCode;
use Response;
use Auth;

class NewsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$articles = News::where('state', 0);
		return View::make('news/index', compact('articles'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Auth::check() && Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			return View::make('news/create');
		} 
		else 
		{
			return View::make('errors/401');
		}
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
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );

		if (News::where('slug', $slug)->first()) 
		{
			return Response::json([0 => 'Deze titel is al gebruikt bij een ander artikel.'], HttpCode::Conflict);
		}

		$input['slug'] = $slug;
		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$article = News::create($input);
		
		if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			$article->state = Input::get('publish') == "true" ? 1 : 0;
		} 
		else
		{
			$article->state = 1;
		}

		foreach ($tags as $tag) 
		{
			$article->tag($tag);
		}

		$article->save();

		$articles = News::where('state', 0);
		return View::make('news/index', compact('articles'));
		/*
		return Response::json([
			0 => 'Nieuws artikel aangemaakt, klik <a href="/news/' . $slug . '">hier</a> om het te bekijken.'
		], HttpCode::Ok);*/
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  string  $slug
	 * @return Response
	 */
	public function show($slug)
	{
		//Bug bij vraagteken in de slug kijg je <error></error>

		$article = News::where('slug', $slug)->first();

		//$tagArray = $article->tagNames();

		if ($article) 
		{
			return View::make('news/show', compact('article','tagArray'));
		} 
		else 
		{
			throw new \Exception('Artikel is niet gevonden in de database.');
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
		if ($article) 
		{
			return View::make('news/edit', compact('article'));
		} 
		else 
		{
			throw new \Exception('Artikel is niet gevonden in de database.');
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
//this is for the edit page
		$input = Input::all();

		$input['content'] = str_replace("\n", '', $input['content']); // remove line endings
		$input['content'] = str_replace("\r", '', $input['content']); // remove line endings

		$slug = strtolower(implode('-', explode(' ', $input['title'])));
		$slug = str_replace('?','', $slug);
		$slug = str_replace('/','',$slug );
		$slug = str_replace('\\','',$slug );
		$input['slug'] = $slug;
		
		$article = News::findOrFail($id);

		if (Auth::user()->hasOnePrivelege(['Moderator', 'Administrator'])) 
		{
			$article->state = Input::get('publish') == "true" ? 0 : 1;
		} 
		else 
		{
			$article->state = 1;
		}

		$article->untag();
		$tags = explode(',', $input['tags']);
		foreach ($tags as $tag) 
		{
			$article->tag($tag);
		}

		$article->update(Input::all());
	
		return Response::json(['Artikel gewijzigd. klik <a href="/news">hier</a> om terug te keren naar het overzicht'], HttpCode::Ok); // 200 = OK
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
		return Response::json([], HttpCode::Ok);
	}
}
