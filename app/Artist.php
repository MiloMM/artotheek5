<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model {

	public $timestamps = false;

	protected $fillable = [
		'name',
		'user'
	];
}
