<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
			'telephone' => 'max:20',
			'education' => 'max:75',
			'school_year' => 'min:1|max:99|integer',
			'delivery_address' => 'required',
			'zip' => 'required|max:7'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{

		$slug = strtolower(implode('-', explode(' ', $data['name'])));

		if (User::where('slug', $slug)->first()) {
			$i = 1;
			while (User::where('slug', $slug . $i)->first()) {
				$i++;
			}
			$slug .= $i;
		}

		$user = User::create([
			'name' => $data['name'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'slug' => $slug,
			'telephone' => $data['telephone'],
			'education' => $data['education'],
			'school_year' => $data['school_year'],
			'delivery_address' => $data['delivery_address'],
			'zip' => $data['zip']
		]);

		$user->priveleges()->attach(1);

		return $user;
	}

}
