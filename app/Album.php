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
	];

	public function band()
	{
		return $this->belongsTo('App\Band', 'band_id', 'band_id');
	}
	public function contents()
	{
		return $this->hasMany('App\Album-Contents');
	}
}
