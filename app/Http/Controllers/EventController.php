<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function addAlbum(Request $request, $bname)
    {
        $band = Band::where('band_name', $bname)->first();
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');

        // $band = Band::where('band_id', $request->input('band_id'))->first();

        if (count($band)>0)
        {
            \Cloudder::upload($albumpic);
            $cloudder=\Cloudder::getResult();
            $create = Album::create([
                'album_name' => $name,
                'album_desc' => $desc,
                'band_id' => $band->band_id,
            ]);
            // dd($create);
        return redirect($band->band_name.'/manage');
        }
        else
        {
            return redirect('/'); 
        }
        

    }
}
