<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Privelege extends Model {

	//
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'priveleges';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'description'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function users()
	{
		return $this->belongsToMany('User', 'user_privelege', 'user_id', 'privelege_id');
	}

}
