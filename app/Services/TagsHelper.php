<?php namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class TagsHelper {

	public static function addTagsToCollection(Collection $collection) {
		for ($i = 0; $i < $collection->count(); $i++) {
			$collection[$i]{"tags"} = $collection[$i]->tagged;
		}
	}

}