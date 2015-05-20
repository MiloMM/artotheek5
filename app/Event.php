<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

	//
	protected $table = 'events';

	protected $fillable = ['title', 'content','start_at','end_at','slug'];

}
