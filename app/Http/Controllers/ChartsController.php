<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
use App\BandGenre;


class ChartsController extends Controller
{
    public function show(){

    	$allbands = Band::join('bandgenres','bands.band_id','=','bandgenres.band_id')->join('genres','bandgenres.genre_id','=','genres.genre_id')->get();
    	return view('top-charts', compact('allbands','bandgenre'));
    }
}
