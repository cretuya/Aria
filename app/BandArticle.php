<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandArticle extends Model
{
    protected $table = 'bandarticles';

    protected $fillable = [
   		'band_id', 
   		'art_id',
    ];

    public function article()
    {
    	return $this->belongsTo('App\Article' ,'art_id');
    }
    public function band()
    {
    	return $this->belongsTo('App\Band', 'band_id');
    }
}
