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
	protected $fillable = ['name', 'email', 'password', 'slug'];

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
	public function hasPriveleges($priveleges, $allRequired = false) {
		$hasIt = false;

		$this->priveleges->each(function ($privelege) {
			if ($allRequired) {
				if (!in_array($privelege, $priveleges)) {
					return;
				}
				$hasIt = true;
			} else {
				if (in_array($privelege, $priveleges)) {
					$hasIt = true;
					return;
				}
			}
		});

		return $hasIt;
	}

}
