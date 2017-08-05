<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album_Contents extends Model
{
	protected $table = 'album-contents';

	protected $fillable = [
		'album_id' , 
		'song_id' , 
	];

	public function song()
	{
		return $this->belongsTo('App\Song');
	}

	public function album()
	{
		return $this->belongsTo('App\Album', 'album_id', 'album_id');
	}

}
