<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Genre;
use App\Song;
use App\Album;
use App\Band;
use App\BandSong;

class SongController extends Controller
{
    public function bandsongs(Request $request)
    {
        $testing = Array();
        $aname = Album::where('album_id', $request->input('album_id'))->first();
        $songs = Song::where('album_id' , $request->input('album_id'))->get();
        // foreach ($albums as $album)
        // {
        //     $song = Song::where('song_id', $album->song_id)->first();
        //     array_push($testing, $song);
        // }

        return response ()->json(['songs' => $songs , 'album' => $aname]);

    }

	public function addSongs(Request $request)
	{
        $id = $request->input('album_id');
        $songDesc = $request->input('song_desc');
        $title = $request->input('song_title');
        $audio = $request->file('song_audio');
        $genre = $request->input('genre_id');
        $aid = Album::where('album_id', $id)->first();
        $band = Band::where('band_id', $request->input('band_id'))->first();
        // foreach ($audios as $audio)
        // {
            $audioPath = $this->addPathforSongs($audio);

            $createSong = Song::create([
                'song_title' => $title,
                'song_desc' => $songDesc,
                'song_audio' => $audioPath,
                'genre_id' => $genre,
                'album_id' => $id,
            ]);
            
        // }
		return response ()->json($createSong);
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


    public function editSong(Request $request)
    {
    	$song = Song::where('song_id', $request->input('song_id'))->first();
    	$album = Album::where('album_id' , $song->album_id)->first();
    	$band = Band::where('band_id' , $album->band_id)->first();

    	return response ()->json(['song' => $song, 'album' => $album, 'band' => $band]);
    }

    public function updateSong(Request $request)
    {
        $id = Song::find($request->input('song_id'));
    	$album = Album::where('album_id', $id->album_id)->first();
    	$band = Band::where('band_id', $album->band_id)->first();
    	$desc = $request->input('song_desc');
    	$genre = $request->input('genre_id');

    	$update = $id->update([
    		'song_desc' => $desc,
    		'genre_id' => $genre,
            'album_id' => $album->album_id,
    	]);



    	return response ()->json ($update);
    }
    public function deleteSong(Request $request)
    {
        $id = Song::where('song_id', $request->input('song_id'))->delete();
    	// $delete = Song::where('song_id', $sid)->delete();
    	return response ()->json($id); 
    }

    public function songs()
    {
        $songs = Song::all();

        if (count($songs) > 0)
        {
           return response() ->json($songs);            
        }
        else
        {
            return response() ->json(['message' => 'No songs in the table.']);   
        }


    }
}
