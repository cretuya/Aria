<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandGenre extends Model
{
    protected $table = 'bandgenres';

    protected $fillable = [
        'band_id' ,
        'genre_id' ,
    ];

    public function band()
    {
    	return $this->belongsTo('App/Band');
    }
    public function genre()
    {
    	return $this->belongsTo('App/Genre');
    }


}

