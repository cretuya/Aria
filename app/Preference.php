<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $table = 'preferences';

    protected $fillable = [
    	'user_id',
        'band_id' ,
        'genre_id' ,
        'album_id' ,
        'pl_id' ,
    ];

    public function user()
    {
    	return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
    public function band()
    {
        return $this->belongsTo('App\Band', 'band_id', 'band_id');
    } 
    public function album()
    {
        return $this->belongsTo('App\Album', 'album_id', 'album_id');
    }     
    public function playlist()
    {
        return $this->belongsTo('App\Playlist', 'pl_id', 'pl_id');
    }
}
