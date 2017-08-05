<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    protected $primaryKey = 'genre_id';

    public function bandgenre()
    {
    	return $this->belongsTo('App\BandGenre');
    }
}
