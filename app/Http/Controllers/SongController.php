<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;
use App\Song;
use App\Album;
use App\Album_Contents;
use App\Band;
use App\BandSong;

class SongController extends Controller
{
	public function index($bname,$aid)
	{
		$band = Band::where('band_name', $bname)->first();
		$songs = Album_Contents::where('album_id', $aid)->get();

		return view('songs', compact('band' ,'songs'));


	}
	public function addSongs(Request $request, $bname)
	{
        $id = $request->input('album_id');
        $title = $request->input('song_desc');
        $audios = $request->file('song_audio');
        $genre = $request->input('genre_id');
        $aid = Album::where('album_id', $id)->first();
        $band = Band::where('band_name', $bname)->first();
        foreach ($audios as $audio)
        {
            $audioPath = $this->addPathforSongs($audio);

            $createSong = Song::create([
                'song_desc' => $title,
                'song_audio' => $audioPath,
                'genre_id' => $genre,
            ]);
  			$createContents = Album_Contents::create([
  				'album_id' => $aid->album_id,
  				'song_id' => $createSong->song_id,
  			]);
            $createBandSongs = BandSong::create([
                'band_id' => $band->band_id,
                'song_id' => $createSong->song_id,

            ]);
            
        }
		return redirect('/'.$bname);
	}
    public function addPathforSongs($audio)
    {
        
        if ($audio != null)
        {           
                $extension = $audio->getClientOriginalExtension();
                if($extension != "bin")
                {
                    
                    $destinationPath = public_path().'/assets/music/';
                    $audioname = $audio->getClientOriginalName();
                    $audio = $audio->move($destinationPath, $audioname); 
                    $audio = $audioname;
                }
        }
        else
        {
            $audio = "";
        }
        return $audio;
    }

    public function viewSongs($aid)
    {
    	$songs = Album_Contents::where('album_id', $aid)->get();

    }

    public function editSong($sid)
    {
    	$cont = Album_Contents::where('song_id', $sid)->first();
    	$song = Song::where('song_id', $sid)->first();
    	$album = Album::where('album_id', $cont->album_id)->first();
    	$band = Band::where('band_id' ,$album->band_id)->first();

    	return view('edit-song', compact('song', 'album', 'band'));
    }

    public function updateSong(Request $request, $sid)
    {
    	$cont = Album_Contents::where('song_id', $sid)->first();
    	$album = Album::where('album_id', $cont->album_id)->first();
    	$band = Band::where('band_id', $album->band_id)->first();
    	$title = $request->input('song_desc');
    	$genre = $request->input('genre_id');

    	$update = Song::where('song_id', $sid)->update([
    		'song_desc' => $title,
    		'genre_id' => $genre,
    	]);
    	return redirect('/'.$band->band_name.'/'.$cont->album_id.'/songs');
    }
    public function deleteSong($bid, $aid, $sid)
    {
    	$delete = Song::where('song_id', $sid)->delete();
    	return redirect('/'.$bid);
    }
}
