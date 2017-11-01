<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plist extends Model
{
	protected $table = 'plists';


	protected $fillable = [
		'genre_id',
		'song_id' , 
		'pl_id' , 
	];


	public function playlist()
	{
		return $this->belongsTo('App\Playlist', 'pl_id', 'pl_id');
	}

	public function songs()
	{
		return $this->belongsTo('App\Song', 'song_id', 'song_id');
	}

	public function genres()
	{
		return $this->hasMany('App\Genre', 'genre_id');
	}
}
