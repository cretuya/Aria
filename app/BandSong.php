<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandSong extends Model
{
    protected $table = 'bandsongs';

    protected $fillable = [
    'band_id',
    'song_id',
    ];

    public function band()
    {
    	return $this->belongsTo('App/Band');
    }

    public function song()
    {
    	return $this->belongsTo('App\Song');
    }
}
