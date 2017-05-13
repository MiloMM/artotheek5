<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class filter extends Model {

	public $timestamps = false;
	
	public function filter_optie() {
		return $this->hasMany('App\filter_optie');
	}

}
