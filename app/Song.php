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

	public function genres()
	{
		return $this->hasMany('App\Genre', 'genre_id');
	} 
	public function album()
	{
		return $this->belongsTo('App\Album', 'album_id', 'album_id');
	}
}
