<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class List extends Model
{
	protected $table = 'plists';


	protected $fillable = [
		'song_id' , 
		'pl_id' , 
	];


	public function playlist()
	{
		return $this->belongsTo('App\Playlist', 'pl_id', 'pl_id');
	}

	public function songs()
	{
		return $this->hasMany('App\Song', 'song_id');
	}

	public function genres()
	{
		return $this->hasMany('App\Genre', 'genre_id');
	}
}
