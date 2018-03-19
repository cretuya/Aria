<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $table = 'visits';

    protected $fillable = [
    	'user_id',
        'band_id' ,
        'aria_visits' ,
    ];

    public function band()
	{
		return $this->belongsTo('App\Band', 'band_id', 'band_id');
	}

}
