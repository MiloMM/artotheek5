<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

abstract class HttpCode extends Controller {

	const Ok = 200;
	const Unauthorized = 401;
	const NotFound = 404;
	const Conflict = 409;

}
