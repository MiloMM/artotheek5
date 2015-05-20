<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use View;

class PagesController extends Controller {

	//
	public function index()
	{
		return View::make('index');
	}

	public function gallery()
	{
		
	}

}
