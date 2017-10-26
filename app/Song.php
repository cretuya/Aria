<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
	protected $table = 'songs';

	protected $primaryKey = 'song_id';

	protected $fillable = [
		'song_title',
		'song_desc' ,
		'song_audio' ,
		'genre_id' , 
		'album_id' ,
	];
	public $rules = [
	'song_title' => 'required|unique:songs',
	'song_desc' => 'required|max:255',
	'song_audio' => 'required|',
	'genre_id' => 'numeric',
	'album_id' => 'numeric',
	];
	public $updaterules = [
	'song_title' => 'required',
	'song_desc' => 'required|max:255',
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
	public function list()
	{
		return $this->belongsTo('App\List', 'song_id', 'song_id');
	}
}
