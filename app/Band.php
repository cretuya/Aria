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
        'num_followers' ,
        'visit_counts' ,
        'weekly_score' ,
        'band_score' ,
        'scored_updated_date',
    ];

	public $rules = [
	'band_name' => 'required|unique:bands|max:50',
	];

	public $updaterules = [
	'band_name' => 'required|unique:bands|max:50',
	'band_desc' => 'max:255',
	];    

    public function albums()
    {
    	return $this->hasMany('App\Album', 'album_id', 'album_id');
    }
	public function members()
	{
		return $this->hasMany('App\Bandmember', 'band_id','band_id');//model,foreign key, local key
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
	public function events()
	{
		return $this->hasMany('App\BandEvent', 'band_id', 'band_id');
	}
}
