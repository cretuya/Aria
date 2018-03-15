<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Band;
use App\BandGenre;
use App\Album;
use App\Song;
use App\Album_Contents;
use App\Genre;
use App\Preference;
// use App\Cloudder;
class AlbumController extends Controller
{
    public function bandalbums(Request $request)
    {
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $albums = Album::where('band_id', $band->band_id)->get();

        return response ()->json(['band' => $band, 'albums' => $albums]);
    }

    public function addAlbum(Request $request)
    {
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $albumpic = $request->file('album_pic');
        $released_date = $request->input('released_date');

        $rdate = date('Y-m-d', strtotime(str_replace('-', '/', $released_date)));
        if (count($band)>0)
        {
            \Cloudder::upload($albumpic);
            $cloudder=\Cloudder::getResult();
            $create = Album::create([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' =>$band->band_id,
                'album_pic' => $cloudder['url'],
                'released_date' => $rdate,
            ]);
        }
        else
        {
            return response()->json(['message' => 'Cannot create album.']); 
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
    public function bandgenres(Request $request)
    {
        $genres = BandGenre::where('band_id', $request->input('band_id'))->get();
        if (count($genres) > 0)
        {
           return response() ->json($genres);            
        }
        else
        {
            return response() ->json(['message' => 'No genres found in the table.']);   
        }
    }
    public function AllAlbums(Request $request){
        $albums = Album::all();
        return response()->json($albums);
    }

    public function likeAlbum(Request $request){
        $userId = $request->input('user_id');
        $albumId =  $request->input('album_id');
        $likes = count(Preference::where('album_id' ,$albumId)->get());
        $newlikes = $likes + 1;

         $create = Preference::create([
                'user_id' => $userId,
                'album_id' => $albumId,
            ]);     
        $update = Album::where('album_id', $albumId)->update([
                'num_likes' => $newlikes
        ]);

        return response ()->json($create);
    }

    public function unLikeAlbum(Request $request){
        $userId = $request->input('user_id');
        $liker = Preference::where([
            ['user_id' , $userId],
            ['album_id', $request->input('album_id')],
            ])->first();

        if (count($liker) > 0)
        {

            $album = Album::where('album_id', $request->input('album_id'))->first();
            $likes = $album->num_likes;
            $newlikes = $likes - 1;

            $update = Album::where('album_id', $album->album_id)->update([
                'num_likes' => $newlikes
             ]);

            $delete = Preference::where([
            ['user_id' , $userId],
            ['album_id', $request->input('album_id')],
            ])->delete();       
        }

        return response ()->json("success");   
    }
}
