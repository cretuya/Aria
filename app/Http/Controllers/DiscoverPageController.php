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
        // dd($recplaylists);
        $topbandweek = Band::orderBy('weekly_score', 'DESC')->take(12)->get();
    	return view('home', compact('allGenres','usernotifinvite', 'topbandweek', 'recplaylists'));
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
                array_push($sorted, $genre);
            }
        } 
        return $sorted;
    }

    public function showSongsGenre($id)
    {
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        $genre = Genre::where('genre_id', $id)->first();

        $songs = Song::where('genre_id', $id)->get();

        return view('view-recommend-playlist', compact('genre', 'songs', 'usernotifinvite'));

    }
}
