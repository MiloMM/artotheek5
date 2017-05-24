<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Artwork;
use View;
use App\News;
use Response;
use App\Services\TagsHelper;
use \Str;

class JsonController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

	public function artworks()
	{
		$artworks = Artwork::whereState(0)->get();
		TagsHelper::addTagsToCollection($artworks);
		return Response::json($artworks->reverse(), 200);
	}

	public function archivedArtworks() 
	{
		$artworks = Artwork::whereState(1)->get();
		TagsHelper::addTagsToCollection($artworks);
		return Response::json($artworks->reverse(), 200);
	}

	public function news() 
	{
		$articles = News::whereState(0)->get();
		foreach ($articles as $article) 
		{
			$article->content = substr($article->content,0,150).'...';
		}
		TagsHelper::addTagsToCollection($articles);
		return Response::json($articles->reverse(), 200);
	}

	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
		//
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
