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
use App\Preference;
use App\SongsPlayed;
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
        $preferences = Preference::where('user_id', $user->user_id)->get();

        $getBandPreferences = Array();
        $getAlbumPreferences = Array();

        foreach($preferences as $preference){
            if($preference->band_id != null)
            {
                array_push($getBandPreferences, $preference);
            }
        }
        foreach($preferences as $preference){
            if($preference->album_id != null){
                array_push($getAlbumPreferences, $preference);
            }
        }

        $genres = Array();
        if(count($getBandPreferences) > 0 ){
            foreach($getBandPreferences as $getBand)
            {
                $band = Band::where('band_id', $getBand->band_id)->first();
                $bandGenres = $band->bandgenres;
                foreach($bandGenres as $bandGenre)
                {
                    array_push($genres, $bandGenre->genre_id);
                }

            }
            $unique = array_unique($genres);
            $sorted = Array();

            foreach($unique as $un){
                $songs = Song::where('genre_id', $un)->get();
                if(count($songs) != null){
                    $genre = Genre::where('genre_id', $un)->first();
                    array_push($sorted, $genre);
                }
            }
            return $sorted;
        }
        else if (count($getAlbumPreferences) > 0) {
            foreach($getAlbumPreferences as $getAlbum)
            {
                $band = $getAlbum->album->band;
                $bandGenres = $band->bandgenres;
                foreach($bandGenres as $bandGenre)
                {
                    array_push($genres, $bandGenre->genre_id);
                }

            }
            $unique = array_unique($genres);
            $sorted = Array();

            foreach($unique as $un){
                $songs = Song::where('genre_id', $un)->get();
                if(count($songs) != null){
                    $genre = Genre::where('genre_id', $un)->first();
                    array_push($sorted, $genre);
                }
            }
            return $sorted;
        }
        else {

            $genres = Genre::all();
            $sorted = Array();

            foreach ($genres as $genre)
            {
                $songs = Song::where('genre_id', $genre->genre_id)->get();
                if (count($songs) != null)
                {
                    array_push($sorted, $genre);
                }
            } 
            return $sorted;            
        }

    }

    public function showSongsGenre($id)
    {
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        $genre = Genre::where('genre_id', $id)->first();
        // $songs = Song::where('genre_id', $id)->get();
        $songs = Array();

        $getSongsPlayed = SongsPlayed::all();
        $getSongs = Array();

          foreach($getSongsPlayed as $getSongPlayed){
            $getGenre = $getSongPlayed->songs->genre_id;
            $array = array('song_id' => $getSongPlayed->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlayed->category);
            if ($getGenre == $genre->genre_id){
                array_push($getSongs, $array);
            }
          }

          if ($getSongs != null){
              $collectSongs = collect($getSongs);
              $groupedSongsbyId = $collectSongs->groupBy('song_id');
              $storeSongwithScore = Array();

              $category1 = 10;
              $category2 = 6;
              $category3 = 2;
            // calculate the scores
            $scoreBasedOnCategory = Array();
            foreach ($groupedSongsbyId as $key => $value) {
                  $countforcat1 = $value->where('category', 1);
                  $countforcat2 = $value->where('category', 2);
                  $countforcat3 = $value->where('category', 3);

                  $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
                  $array = array('song_id' => $key, 'scoreforsong' => $getScoreforCats);
                  array_push($scoreBasedOnCategory, $array);

            }

            // sort songs
            $collectSongs = collect($scoreBasedOnCategory);
            $sortBySongs = $collectSongs->sortByDesc('scoreforsong');
            $songs = Array();
              foreach ($sortBySongs as $key => $value) {
                $song = Song::where('song_id', $value['song_id'])->first();
                array_push($songs, $song);
              }
          } else {
                $getSongs = Song::where('genre_id', $id)->get();
                $getBandsofSong = Array();

                foreach ($getSongs as $song) {
                    $bandscore = $song->album->band->band_score;
                    $array = array('song_id' => $song->song_id, 'band_score' => $bandscore);
                    array_push($getBandsofSong, $array);
                }
                $collectBandsOfSong = collect($getBandsofSong);
                $sortSongs = $collectBandsOfSong->sortByDesc('band_score'); 
                $songs = Array();
                foreach ($sortSongs as $sortSong) {
                    $song = Song::where('song_id', $sortSong['song_id'])->first();
                    array_push($songs, $song);
                }

          }

          
        return view('view-recommend-playlist', compact('genre', 'songs', 'usernotifinvite'));

    }
}
