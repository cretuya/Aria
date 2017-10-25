<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserNotification;
use App\Band;
use App\BandGenre;


class ChartsController extends Controller
{
    public function show(){

    	$allbands = Band::join('bandgenres','bands.band_id','=','bandgenres.band_id')->join('genres','bandgenres.genre_id','=','genres.genre_id')->get();
    	$usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
    	return view('top-charts', compact('allbands','bandgenre','usernotifinvite'));
    }
}
