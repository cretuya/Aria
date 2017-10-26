<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\UserNotification;
use App\Genre;
use App\BandGenre;
class DiscoverPageController extends Controller
{
    public function showAllGenres(){
    	$allGenres = DB::table('genres')->get();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
    	return view('discover', compact('allGenres','usernotifinvite'));
    }

    public function showAccordingtoGenre($genreName){
    	$genreChoice = Genre::where('genre_name', $genreName)->first();

    	$bands = BandGenre::where('genre_id', $genreChoice->genre_id)->get();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
    	// dd($bands);
    	// dd($genreChoice);
    	return view('discover-genre', compact('genreChoice', 'bands','usernotifinvite'));
    }
}
