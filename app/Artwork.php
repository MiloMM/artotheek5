<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Artwork extends Model {

	use \Conner\Tagging\TaggableTrait; // Tags
	use SearchableTrait;

	protected $fillable = ['title', 'description', 'file', 'state', 'slug','reserved', 'artist', 'technique', 'category', 'size', 'price'];
	protected $table = 'artworks';

	protected $searchable = [
		'columns' => [
			'artworks.title' => 10,
			'artworks.description' => 5,
		]
	];

	public function tagsToHumanReadableString()
	{
		$tags = $this->tagged;
		if ($tags->count() == 0) 
		{
			return 'Er zijn geen tags voor dit artikel';
		}
		$str = "";
		$i = 0;
		foreach ($tags as $tag) 
		{
			if ($i != $tags->count() - 1) 
			{
				$str .= $tag->tag_name . ', ';
			} 
			else 
			{
				$str .= $tag->tag_name;
			}
			$i++;
		}
		return $str;
	}

	public function tagsToTagsInput() 
	{
		$tags = $this->tagged;

		$str = "";
		$i = 0;

		foreach ($tags as $tag) 
		{
			if ($i != $tags->count() - 1) 
			{
				$str .= $tag->tag_name . ',';
			} 
			else 
			{
				$str .= $tag->tag_name;
			}
			$i++;
		}
		return $str;
	}	
}
	