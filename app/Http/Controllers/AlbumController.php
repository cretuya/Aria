<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
use App\Album;
use App\Song;
use App\Album_Contents;
class AlbumController extends Controller
{
    public function index($name)
    {
        $band = Band::where('band_name', $name)->first();
        $albums = Album::where('band_id', $band->band_id)->get();

        return view('band-albums', compact('band', 'albums'));
    }

    public function addAlbum(Request $request, $bname)
    {
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');

        $band = Band::where('band_name', $bname)->first();
        if (count($band)>0)
        {
            $create = Album::create([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' =>$band->band_id,
            ]);
        }
        else
        {
            return redirect('/'); 
        }
        
        return redirect('/'.$band->band_name.'/manage');
    }

    public function viewAlbum($bname, $aid)
    {
        $album = Album::where('album_id', $aid)->first();
        return view('view-band-album', compact('album'));

    }

    public function editAlbum($bname, $aid)
    {
        $album = Album::where('album_id', $aid)->first();
        $band = Band::where('band_name', $bname)->first();

        return view('edit-band-album', compact('album', 'band'));
    }

    public function updateAlbum(Request $request, $bname)
    {
        
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $aid = $request->input('album_id');

        $band = Band::where('band_name', $bname)->first();
        if (count($band)>0)
        {
            $create = Album::where('album_id' , $aid)->update([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' =>$band->band_id,
            ]);
        }
        else
        {
            
        }
         return redirect('/'.$bname.'/manage');
    }
    public function deleteAlbum($aid)
    {
        $al = Album::where('album_id', $aid)->first();
        $bid = $al->band_id;
        $band = Band::where('band_id', $bid)->first();
        $delete = Album::where('album_id', $aid)->delete();


        return redirect('/'.$band->band_name.'/manage');
    }

}
