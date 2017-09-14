<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Genre;

class DiscoverPageController extends Controller
{
    public function showAllGenres(){
    	$allGenres = DB::table('genres')->get();
    	return view('discover', compact('allGenres'));
    }

    public function showAccordingtoGenre($genreName){
    	$genreChoice = Genre::where('genre_name', $genreName)->first();
    	// dd($genreChoice);
    	return view('discover-genre', compact('genreChoice'));
    }
}
