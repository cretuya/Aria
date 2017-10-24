<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'usernotifications';

	protected $fillable = [
		'band_id' , 
		'user_id' ,
		'bandrole' ,
		'invitor' ,
	];
}
