<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $table = 'songs';

	protected $primaryKey = 'song_id';

	protected $fillable = [
		'song_desc' ,
		'song_audio' ,
		'genre_id' , 
		'album_id' ,
	];
	public $rules = [
	'song_desc' => 'required|max:255',
	'song_audio' => 'required',
	'genre_id' => 'numeric',
	'album_id' => 'numeric',
	];
	public $updaterules = [
	'song_desc' => 'required|max:255',
	'song_audio' => 'required',
	'genre_id' => 'numeric',
	'album_id' => 'numeric',
	];
	
	public function genres()
	{
		return $this->hasMany('App\Genre', 'genre_id');
	} 
	public function album()
	{
		return $this->belongsTo('App\Album', 'album_id', 'album_id');
	}
}
