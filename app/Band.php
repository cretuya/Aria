<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Band extends Model
{
	protected $table = 'bands';

	protected $guarded = ['band_id'];

	protected $fillable = [
        'band_name' ,
        'band_desc' , 
    ];

    public function albums()
    {
    	return $this->hasMany('App\Album', 'album_id');
    }
	public function members()
	{
		return $this->hasMany('App\Bandmembers', 'band_id');
	}
	public function bandvids()
	{
		return $this->hasMany('App\BandVideo');
	}
	public function bandarticles()
	{
		return $this->hasMany('App\Bandarticles');
	}
	public function bandgenres()
	{
		return $this->hasMany('App\BandGenre');
	}
	public function bandsongs()
	{
		return $this->hasMany('App\BandSong');
	}
}
