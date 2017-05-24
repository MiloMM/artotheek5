<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model{

	protected $table = 'reservations';
	protected $fillable = ['artwork_id', 'user_id', 'from_date', 'to_date', 'delivery_adress'];

}
