<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BandEvent extends Model
{
    protected $table = 'bandevents';

    protected $fillable = [
   		'band_id', 
   		'event_id',
        'event_name', 
        'event_date', 
        'event_time', 
        'event_venue',
        'event_location',
    ];
    
    public function band()
    {
    	return $this->belongsTo('App\Band', 'band_id', 'band_id');
    }
}
