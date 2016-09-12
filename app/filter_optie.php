<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class filter_optie extends Model {

	public function filter() {
		return $this->belongsTo('App\filter');
	}

}
