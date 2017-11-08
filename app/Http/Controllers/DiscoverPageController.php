<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\UserNotification;
use App\Genre;
use App\BandGenre;
use App\Band;
use App\Album;
use App\Song;
use Auth;
class DiscoverPageController extends Controller
{
    public function showAllGenres(){
    	$allGenres = DB::table('genres')->get();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        $recplaylists = $this->recommend();
        dd($recplaylists);
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

    public function recommend()
    {
        $user = Auth::user();

        $genres = Genre::all();
        // $randomSongs = Song::inRandomOrder()->get();

        // $songs = Song::all();
        $sorted = Array();
        $compact = Array();
        foreach ($genres as $genre)
        {
            // foreach ($songs as $song)
            // {
            //     if ($song->genre_id == $genre->genre_id)
            //     {
            //         $data = array('genre' => $genre->genre_id, 'song' => $song);
            //         array_push($sorted, $data);
            //     }
            // }
            $songs = Song::where('genre_id', $genre->genre_id)->get();
            if (count($songs) != null)
            {
                if (count($songs) > 2)
                {
                    foreach($songs as $song)
                    {
                        array_push($compact, $song);
                    }
                    array_push($sorted, $compact);
                }
                else
                {
                array_push($sorted, $songs);
                    
                }
            }
        } 
        return $sorted;
    }
}
