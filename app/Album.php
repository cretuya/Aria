<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
	protected $table = 'bandalbums';

	protected $guarded = ['album_id'];

	protected $fillable = [
		'album_name' , 
		'album_desc' , 
		'band_id' , 
		'album_pic',
	];

	public $rules = [
	'album_name' => 'required|max:100',
	'album_desc' => 'required|max:255',
	'album_pic' => 'required|max:255',
	];

	public $updaterules = [
	'album_name' => 'required|max:100',
	'album_desc' => 'required|max:255',
	'album_pic' => 'required|max:255',
	];

	public function band()
	{
		return $this->belongsTo('App\Band', 'band_id', 'band_id');
	}
	public function songs()
	{
		return $this->hasMany('App\Songs','album_id');
	}
	public function preferences()
	{
		return $this->hasMany('App\Preference', 'band_id', 'band_id');
	}
}
