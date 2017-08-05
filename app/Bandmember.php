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

}
