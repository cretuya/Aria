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
                'album_id' => $id,
            ]);
            
        }
		return redirect('/'.$bname.'/manage');
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

    public function viewSongs(Request $request, $bname)
    {
        $testing = Array();
        $aname = Album::where('album_id', $request->input('id'))->first();
    	$songs = Song::where('album_id' , $request->input('id'))->get();
        // foreach ($albums as $album)
        // {
        //     $song = Song::where('song_id', $album->song_id)->first();
        //     array_push($testing, $song);
        // }

        return response ()->json(['songs' => $songs , 'album' => $aname]);

    }

    public function editSong($sid)
    {
    	$cont = Album_Contents::where('song_id', $sid)->first();
    	$song = Song::where('song_id', $sid)->first();
    	$album = Album::where('album_id', $cont->album_id)->first();
    	$band = Band::where('band_id' ,$album->band_id)->first();

    	return view('edit-song', compact('song', 'album', 'band'));
    }

    public function updateSong(Request $request)
    {
    	// $cont = Album_Contents::where('song_id', $sid)->first();
        dd($request);
        $id = Song::find($request->input('song_id'));
    	$album = Album::where('album_id', $id->album_id)->first();
    	$band = Band::where('band_id', $album->band_id)->first();
    	$desc = $request->input('song_desc');
    	$genre = $request->input('genre_id');

    	$update = Song::where('song_id', $id)->update([
    		'song_desc' => $desc,
    		'genre_id' => $genre,
            'album_id' => $album->album_id,
    	]);


    	return redirect('/'.$band->band_name.'/manage');
    }
    public function deleteSong($sid)
    {
        $id = Song::where('song_id', $sid)->first();
    	$delete = Song::where('song_id', $sid)->delete();
    	return response ()->json($id); 
    }
}
