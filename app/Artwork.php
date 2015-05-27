<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model {

	protected $fillable = ['title', 'description', 'file', 'state'];
	protected $table = 'artworks';

}
	