<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Playlist extends Model
{
	protected $table = 'playlists';

	protected $guarded = ['pl_id'];

	protected $fillable = [
		'pl_title' , 
		// 'pl_desc' , 
		'pl_creator' , 
		'image',
		'followers',
	];

	public $rules = [
		'pl_title'  =>'required|max:200|unique:playlists', 
		// 'pl_desc'   =>'required', 
		// 'pl_creator'=>'required', 
		'followers' =>'numeric',
	];

	public $updaterules = [
		'pl_title'  =>'required|max:200|unique:playlists', 
		// 'pl_desc'   =>'required', 
		// 'pl_creator'=>'required', 
		'followers' =>'numeric',
	];

	public function user()
	{
		return $this->belongsTo('App\User', 'user_id', 'user_id');
	}

	public function preferences()
	{
		return $this->hasMany('App\Preference', 'pl_id');
	}

	public function lists()
	{
		return $this->hasMany('App\Plist', 'pl_id');
	}
}
