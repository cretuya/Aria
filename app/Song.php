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
	];

	public function genres()
	{
		return $this->hasMany('App\Genre', 'genre_id');
	} 
	public function content()
	{
		return $this->hasMany('App\Album-Contents');
	}
	public function bandsongs()
	{
		return $this->hasMany('App\BandSong');
	}
}
