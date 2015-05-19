<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model {

	use \Conner\Tagging\TaggableTrait; // Tags

	protected $table = 'news';

	protected $fillable = ['title', 'content', 'slug'];

	public static function allWithoutArchived()
	{
		return static::where('state', 1)->get();
		
	}

}
