<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bandmember extends Model
{
	protected $table = 'bandmembers';

	protected $fillable = [
        'band_id' , 
        'user_id' , 
        'bandrole'
    ];

    public function band(){
    	return $this->belongsTo('App\Band','band_id','band_id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','user_id');
    }
    
}
