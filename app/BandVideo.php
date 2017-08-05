<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandVideo extends Model
{
    protected $table = 'bandvideos';

    protected $fillable = [
    	'band_id' , 
    	'video_id' ,
    ];

    public function video()
    {
    	return $this->belongsTo('App\Video', 'video_id','video_id');
    }
    public function bands()
    {
    	return $this->belongsTo('App\Band', 'band_id');
    }
}
