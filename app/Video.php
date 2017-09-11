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
    public $rules = [
    'video_desc' => 'required|max:255',
    'video_content' => 'required',
    ];
    public $updaterules = [
    'video_desc' => 'required|max:255',
    'video_content' => 'required',
    ];

    public function bandvideos()
    {
    	return $this->hasMany('App\BandVideo', 'video_id');
    }

}
