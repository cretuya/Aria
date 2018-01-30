<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserNotification;
use App\Band;
use App\Album;
use App\Song;
use App\Album_Contents;
use App\Preference;
use Auth;   
use Validator;
class AlbumController extends Controller
{
    // public function index($name)
    // {
    //     $band = Band::where('band_name', $name)->first();
    //     $albums = Album::where('band_id', $band->band_id)->get();

    //     return view('band-albums', compact('band', 'albums'));
    // }
    public function albums($bname)
    {
        $band = Band::where('band_name', $bname)->first();
        $albums = Album::where('band_id',$band->band_id)->get();
        $likers = Array();
        foreach ($albums as $album)
        {
        $liker = Preference::where([
            ['user_id' , Auth::user()->user_id],
            ['album_id', $album->album_id],
            ])->first();     

            if ($liker == null)
            {

            }
            else
            {
                array_push($likers, $liker->album_id);
            }
        }

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        // dd($likers);
        return view('view-band-album', compact('band', 'albums', 'likers','usernotifinvite'));
    }
    public function addAlbum(Request $request, $bname)
    {
        $band = Band::where('band_name', $bname)->first();
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $albumpic = $request->file('album_pic');

        // $band = Band::where('band_id', $request->input('band_id'))->first();

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
            // dd($create);
        return redirect($band->band_name.'/manage');
        }
        else
        {
            return redirect('/'); 
        }
        

    }

    public function viewAlbum($bname, $aid)
    {
        $albums = Album::where('album_id', $aid)->first();
        $band = Band::where('band_name', $bname)->first();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        // dd($albums->songs);

        return view('view-band-album', compact('albums', 'band', 'usernotifinvite'));

    }

    public function editAlbum($bname, $aid)
    {
        $albums = Album::where('album_id', $aid)->first();
        $band = Band::where('band_name', $bname)->first();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        return view('edit-band-album', compact('albums', 'band', 'usernotifinvite'));
    }

    public function updateAlbum(Request $request, $bname)
    {
        
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $aid = $request->input('album_id');
        $rules = new Album;
        $validator = Validator::make($request->all(), $rules->updaterules);        
        $band = Band::where('band_name', $bname)->first();
        if ($validator->fails())
        {
            return redirect('/'.$bname.'/manage')->withErrors($validator)->withInput();
        }
        else
        {
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
    }
    public function deleteAlbum($aid)
    {
        $al = Album::where('album_id', $aid)->first();
        $bid = $al->band_id;
        $band = Band::where('band_id', $bid)->first();
         // \Cloudder::delete($band->band_pic, array $options);
        $delete = Album::where('album_id', $aid)->delete();



        return redirect('/'.$band->band_name.'/manage');
    }

    public function likeAlbum(Request $request)
    {
        $album = Album::where('album_id', $request->input('id'))->first();
        $likes = $album->num_likes;
        $newlikes = $likes + 1;

        if (count($album) > 0)
        {
            $update = Album::where('album_id', $album->album_id)->update([
                'num_likes' => $newlikes
             ]);
            $create = Preference::create([
                'user_id' => Auth::user()->user_id,
                'album_id' => $album->album_id,
            ]);
            $newalbum = $create->album;            

        }
        
        scoringfunc($band->band_id);

        return response ()->json(['album' => $newalbum, 'liker' => $create]);

    }

    public function unlikeAlbum(Request $request)
    {
        $liker = Preference::where([
            ['user_id' , Auth::user()->user_id],
            ['album_id', $request->input('id')],
            ])->first();

        if (count($liker) > 0)
        {

            $album = Album::where('album_id', $request->input('id'))->first();
            $likes = $album->num_likes;
            $newlikes = $likes - 1;

            $update = Album::where('album_id', $album->album_id)->update([
                'num_likes' => $newlikes
             ]);

            $delete = Preference::where([
            ['user_id' , Auth::user()->user_id],
            ['album_id', $request->input('id')],
            ])->delete();
            $newalbum = $liker->album;            

        }
        return response ()->json($newalbum);   



        if (count($follower) > 0)
        {   
            $band = Band::where('band_id' , $request->input('bid'))->first();            
            $numfollow = $band->num_followers;
            $newfollowers = $numfollow - 1;
            $update =  Band::where('band_id', $request->input('bid'))->update([
            'num_followers' => $newfollowers
            ]);

            $delete = Preference::where([
            ['user_id' , $request->input('uid')],
            ['band_id', $request->input('bid')],
            ])->delete();
            $newband = $follower->band;
        }

        return response ()->json(['band' => $newband, 'preference' => $follower]);            
    }    

}
