<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Auth;

class Artwork extends Model {

	use \Conner\Tagging\TaggableTrait; // Tags
	use SearchableTrait;

	protected $fillable = ['title', 'description', 'file', 'state', 'slug','reserved', 'artist', 'technique', 'category', 'genre', 'size', 'price', 'colour', 'material'];
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
		
		if (substr($str, 0, 1) === ',') {
			$str = substr($str, 1);
		}
		
		return $str;
	}
	
	public static function mailArtworkRequest()
	{
		$to = "galleria@galleria.dvc-icta.nl";
		$subject = "Gallerij verzoek ingediend door " . Auth::user()->name;
		$message = "
		<html>
			<head>
			<title>HTML email</title>
			</head>
			<body style='font-family:Arial;'>
				<p>" . Auth::user()->name . " heeft een kunstwerk verzoek ingediend. Klik hier om deze te bekijken:</p>
				<a href='http://" . $_SERVER['SERVER_NAME'] . "/gallery/archive' style='background:#337ab7;color:white;text-decoration:none;padding:5px 15px 5px 15px;border-radius:10px;'>Bekijk kunstwerk</a>
			</body>
		</html>";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: " . Auth::user()->name . " <" . Auth::user()->email . ">\r\n";
		
		mail($to, $subject, $message, $headers)or die('mail error');
	}
}
	