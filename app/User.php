<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password', 'slug', 'telephone', 'education' ,'school_year', 'delivery_address', 'zip', 'sector', 'biography'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function priveleges()
	{
		return $this->belongsToMany('App\Privelege', 'user_privelege', 'user_id', 'privelege_id');
	}

	/**
	 * @param $user array The user
	 * @param $allRequired bool Needs all priveleges to be on the user
	 * @return bool user has the following priveleges
	 */
	public function hasOnePrivelege($reqPriveleges)
	{
		// when filter returns true then it adds to the collection, then we count the collection to see
		// if we match one of the required priveleges
		return $this->priveleges->filter(function ($privelege) use ($reqPriveleges){
			return in_array($privelege->name, $reqPriveleges);
		})->count() > 0;
	}

	public function hasAllPriveleges($reqPriveleges)
	{
		// when filter returns true then it adds to the collection, then we count the collection to see
		// if we have all of the required priveleges given
		return $this->priveleges->filter(function ($privelege) use ($reqPriveleges){
			return in_array($privelege->name, $reqPriveleges);
		})->count() == count($reqPriveleges);
	}

}
