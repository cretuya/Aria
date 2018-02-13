<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongsPlayed extends Model
{
    protected $table = 'songsplayed';

    protected $fillable = [
    	'user_id',
        'song_id' ,
        'category' ,
    ];

    public function songs()
	{
		return $this->belongsTo('App\Song', 'song_id', 'song_id');
	}
}
