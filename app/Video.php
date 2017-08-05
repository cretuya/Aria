<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'videos';

    protected $primaryKey = 'video_id';

    protected $fillable = [
    	'video_desc' , 
    	'video_content' ,
    ];

    public function bandvideos()
    {
    	return $this->hasMany('App\BandVideo');
    }

}
