<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Band;
use App\Album;
use App\Song;
use App\Album_Contents;
use App\Genre;
// use App\Cloudder;
class AlbumController extends Controller
{
    public function albums(Request $request)
    {
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $albums = Album::where('band_id', $band->band_id)->get();

        return response ()->json(['band' => $band, 'albums' => $albums]);
    }

    public function addAlbum(Request $request)
    {
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $albumpic = $request->file('album_pic');

        $band = Band::where('band_id', $request->input('band_id'))->first();
        if (count($band)>0)
        {
            \Cloudder::upload($albumpic);
            $cloudder=\Cloudder::getResult();
            $create = Album::create([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' =>$band->band_id,
                'album_pic' => $cloudder['url'],
            ]);
        }
        else
        {
            return redirect('/'); 
        }
        
        return response ()->json($create);
    }

    public function editAlbum(Request $request)
    {
        $album = Album::where('album_id', $request->input('album_id'))->first();
        $band = Band::where('band_id', $album->band_id)->first();

        return response ()->json(['band' => $band, 'albums' => $album]);
    }

    public function updateAlbum(Request $request)
    {
        
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $aid = $request->input('album_id');

        $band = Band::where('band_id', $request->input('band_id'))->first();
        if (count($band)>0)
        {
            $update = Album::where('album_id' , $aid)->update([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' =>$band->band_id,
            ]);
        }
        else
        {
            
        }
         return response ()->json($update);
    }
    public function deleteAlbum(Request $request)
    {
        $delete = Album::where('album_id', $request->input('album_id'))->delete();

        return response ()->json($delete);
    }
    public function genres()
    {
        $genres = Genre::all();

        return response ()->json($genres);
    }
}
