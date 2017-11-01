<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    protected $primaryKey = 'genre_id';

    public function bandgenre()
    {
    	return $this->hasMany('App\BandGenre', 'genre_id');
    }
    public function list()
    {
    	return $this->belongsTo('App\Plist', 'genre_id', 'genre_id');
    }
    public function songs()
    {
        return $this->hasMany('App\Song', 'song_id');
    }
}
