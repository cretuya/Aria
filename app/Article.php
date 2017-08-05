<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $primaryKey = 'art_id';

    protected $fillable = [
    	'art_title' , 
    	'content' , 
    ];

    public function bandarticles()
    {
    	return $this->hasMany('App\BandArticle', 'art_id');
    }
}
