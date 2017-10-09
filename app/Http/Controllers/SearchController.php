<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
use App\User;
use App\Genre;
use App\BandGenre;
use App\Album;
use App\Song;
use App\Video;
use App\Article;
use App\UserHistory;

class SearchController extends Controller
{
    public function search(Request $request)
    {
    	// dd($request->search_result);
    	$termSearched = $request->search_result;

    	//for people tab
    	$searchResultUser = User::where('fullname', 'LIKE' , '%'.$termSearched.'%')->get();

    	//for band tab
    	$band = Band::where('band_name', $termSearched)->first();
    	$searchResultBand = Band::where('band_name', 'LIKE' , '%'.$termSearched.'%')->get();
        // dd($searchResultBand);
    	$bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();
    	// dd($bandGenre);
    	// $bandGenreid = BandGenre::where('band_id',$searchResultBand[0]->band_id)->get();
    	// $bandGenre1 = Genre::select('genre_name')->where('genre_id',$bandGenreid[0]->genre_id)->first();
    	// $bandGenre2 = Genre::select('genre_name')->where('genre_id',$bandGenreid[1]->genre_id)->first();
    	// dd($bandGenre1,$bandGenre2);

    	//for album tab
    	$searchResultAlbum = Album::where('album_name', 'LIKE' , '%'.$termSearched.'%')->get();

    	//for song tab
    	$searchResultSong = Song::where('song_audio', 'LIKE' , '%'.$termSearched.'%')->get();

    	//for video tab
    	$searchResultVideo = Video::where('video_desc', 'LIKE' , '%'.$termSearched.'%')->get();

    	//for article tab
    	$searchResultArticle = Article::where('art_title', 'LIKE' , '%'.$termSearched.'%')->get();

    	if (count($band) > 0) {

    		$genreBandSearched1 = UserHistory::create([
			'user_id' => session('userSocial')['id'],
			'genre_searched' => $bandGenre[0]->genre_name,
			'term_searched' => $termSearched,
			]);

			$genreBandSearched2 = UserHistory::create([
			'user_id' => session('userSocial')['id'],
			'genre_searched' => $bandGenre[1]->genre_name,
			'term_searched' => $termSearched,
			]);
    	}

    	if (count($searchResultSong) > 0) {

    		$songGenre = Genre::select('genre_name')->join('songs', 'genres.genre_id', '=', 'songs.genre_id')->first();

    		$genreSongSearched = UserHistory::create([
			'user_id' => session('userSocial')['id'],
			'genre_searched' => $songGenre->genre_name,
			'term_searched' => $termSearched,
			]);
    	}

    	return view('search-result',compact('searchResultBand','searchResultUser','searchResultGenre','searchResultAlbum','searchResultSong','searchResultVideo','searchResultArticle','termSearched','band','bandGenre'));

    }
}
