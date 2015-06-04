<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Artwork extends Model {

	use \Conner\Tagging\TaggableTrait; // Tags

	protected $fillable = ['title', 'description', 'file', 'state', 'slug'];
	protected $table = 'artworks';

}
	