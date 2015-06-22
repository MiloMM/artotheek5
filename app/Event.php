<?php namespace App;

use Illuminate\Database\Eloquent\Model;



class Event extends Model {

	use \Conner\Tagging\TaggableTrait; // Tags
	//
	protected $table = 'events';

	protected $fillable = ['title', 'content','state','slug'];

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
