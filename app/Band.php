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
    	return $this->hasMany('App\Album', 'album_id', 'album_id');
    }
	public function members()
	{
		return $this->hasMany('App\Bandmembers', 'band_id');
	}
	public function bandvids()
	{
		return $this->hasMany('App\BandVideo', 'band_id', 'band_id');
	}
	public function bandarticles()
	{
		return $this->hasMany('App\Bandarticle', 'band_id', 'band_id');
	}
	public function bandgenres()
	{
		return $this->hasMany('App\BandGenre', 'band_id', 'band_id');
	}
	public function bandsongs()
	{
		return $this->hasMany('App\BandSong');
	}
	public function preferences()
	{
		return $this->hasMany('App\Preference', 'band_id', 'band_id');
	}
}
