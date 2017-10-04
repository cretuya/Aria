<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model
{
    protected $table = 'userhistory';

	protected $guarded = ['user_id'];
	public $incrementing = false;


	protected $fillable = [
        'user_id' ,
        'genre_searched' , 
        'term_searched' , 
    ];
}
