<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserNotification;
use App\Band;
use App\Genre;
use App\Album;
use App\Song;
use App\SongsPlayed;
use App\Album_Contents;
use App\Preference;
use App\Visit;
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
        $released_date = $request->input('released_date');


        $rdate = date('Y-m-d', strtotime(str_replace('-', '/', $released_date)));
        // dd($rdate);
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
                'released_date' => $rdate,
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
        $liked = Preference::where([
            ['user_id' , Auth::user()->user_id],
            ['album_id', $albums->album_id],
            ])->first();     
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        // dd($albums->songs);
        // dd($liked);

        return view('view-band-album', compact('albums', 'band', 'usernotifinvite', 'liked'));

    }

    public function editAlbum($bname, $aid)
    {
        $albums = Album::where('album_id', $aid)->first();
        $band = Band::where('band_name', $bname)->first();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        $genres = Genre::all();

        return view('edit-band-album', compact('albums', 'band', 'usernotifinvite','genres'));
    }

    public function updateAlbum(Request $request, $bname)
    {
        
        $name = $request->input('album_name');
        $desc = $request->input('album_desc');
        $aid = $request->input('album_id');
        $albumpic = $request->file('album_pic');
        $released_date = $request->input('released_date');
        $rules = new Album;
        $validator = Validator::make($request->all(), $rules->updaterules);        
        $band = Band::where('band_name', $bname)->first();
        $rdate = date('Y-m-d', strtotime(str_replace('-', '/', $released_date)));
        if ($validator->fails())
        {
            return redirect('/'.$bname.'/manage')->withErrors($validator)->withInput();
        }
        else
        {
            if (count($band)>0)
            {
                \Cloudder::upload($albumpic);
                $cloudder=\Cloudder::getResult();
                $create = Album::where('album_id' , $aid)->update([
                    'album_name' => $name,
                    'album_desc' => $desc,
                    'band_id' =>$band->band_id,
                    'album_pic' => $cloudder['url'],
                    'released_date' => $rdate,
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
        
        $this->scoringfunc();

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

        $this->scoringfunc();

        return response ()->json($newalbum);   



        // if (count($follower) > 0)
        // {   
        //     $band = Band::where('band_id' , $request->input('bid'))->first();            
        //     $numfollow = $band->num_followers;
        //     $newfollowers = $numfollow - 1;
        //     $update =  Band::where('band_id', $request->input('bid'))->update([
        //     'num_followers' => $newfollowers
        //     ]);

        //     $delete = Preference::where([
        //     ['user_id' , $request->input('uid')],
        //     ['band_id', $request->input('bid')],
        //     ])->delete();
        //     $newband = $follower->band;
        // }

        // return response ()->json(['band' => $newband, 'preference' => $follower]);            
    }

    public function addSongPlayedAsScore(Request $request){
        $durationPlayed = $request->input('durationPlayed');
        // dd('hello');
        $userid = Auth::user()->user_id;
        $songid = $request->input('songID');
        $categoryFull = 1;
        $categoryMore = 2;
        $categoryLess = 3;

        // dd($durationPlayed,$userid,$categoryFull,$categoryMore,$categoryLess);

        if ($durationPlayed < 40) {
            $create = SongsPlayed::create([
                'user_id' => $userid,
                'song_id' => $songid,
                'category' => $categoryLess,
            ]);
        }else if ($durationPlayed > 40 && $durationPlayed <= $request->input('prevSong')) {
            $create = SongsPlayed::create([
                'user_id' => $userid,
                'song_id' => $songid,
                'category' => $categoryMore,
            ]);
        }else{
            $create = SongsPlayed::create([
                'user_id' => $userid,
                'song_id' => $songid,
                'category' => $categoryFull,
            ]);
        }

        $this->scoringfunc();
    }

    public function scoringfunc(){

            $bands = Band::all();
            $albums = Album::all();
            $maxUseralbumlikes = Preference::distinct()->where('album_id','!=',null)->get(['user_id']);
            $numUsersDunayGiLike = count($maxUseralbumlikes);
            $maxvisitcount = 0;
            $maxUserfollowers = Preference::distinct()->where('band_id','!=',null)->get(['user_id']);
            $numUsersDunayGiFollow = count($maxUserfollowers);
            $ariavisits = Visit::distinct()->where('aria_visits','!=',null)->get(['user_id']);
            $totalariavisits= count($ariavisits);
            
            // $visitcountArray = array();

            // dd($numUsersDunayGiFollow);

            //get the total number of likes sa tanan album
            // foreach ($albums as $tananalbums) {
            //     $maxalbumlikes += $tananalbums->num_likes;
            // }

            //get the total number of visit counts sa tanan bands
            //get the total number of followers
            // foreach ($bands as $tananbanda) {
            //     $maxvisitcount += $tananbanda->visit_counts;
            //     $maxfollowers += $tananbanda->num_followers;
            // }

            //start for scoring
            foreach ($bands as $tananbanda) {
                $visits = Visit::distinct()->where('band_id',$tananbanda->band_id)->get(['user_id']);
                $bandVisitCounts = count($visits);
                $bandAlbumLikes = 0;
                $bandFollowers = $tananbanda->num_followers;
                // $bandVisitCounts = $tananbanda->visit_counts;
                $songScore=0;
                $score = 0;
                $bandScore = 0;
                $maxSongScore = 0;
                $maxSongCount = 0;
                // array_push($visitcountArray,$bandVisitCounts);
                foreach ($tananbanda->albums as $album) {
                    $bandAlbumLikes += $album->num_likes;
                    // echo $album->band->band_name." ".$album->album_name." ".$album->num_likes."<br>";
                    foreach ($album->songs as $songs) {
                        $maxSongCount += count($songs->songsplayed);
                        foreach($songs->songsplayed as $songsplayed){
                            // echo $songsplayed->category."<br>";
                            // echo "song id: ".$songsplayed->song_id." category: ".$songsplayed->category." band name: ".$songsplayed->songs->album->band->band_name."<br>";
                            if ($songsplayed->category == 1) {
                                $songScore += 10;
                            }else if ($songsplayed->category == 2) {
                                $songScore += 6;
                            }else{
                                $songScore += 2;
                            }
                        }
                    }
                    // echo $songScore." song score<br>";
                    // echo $maxSongCount."max song count<br>";
                }

                // $highestVisitCount = max($visitcountArray);
                // echo $highestVisitCount."<br>";
                // echo $numUsersDunayGiLike."like<br>";
                // echo $numUsersDunayGiFollow."follow<br>";
                // echo $totalariavisits." ang total distinct users naka visit sa aria page after login<br>";
                // echo $bandVisitCounts." distinct visit counts ".$tananbanda->band_name."<br>";
                if ($numUsersDunayGiLike != 0) {
                    $albumlikeScore = (($bandAlbumLikes/$numUsersDunayGiLike)*15);
                }else{
                    $albumlikeScore = 0;
                }

                if ($numUsersDunayGiFollow != 0) {
                    $followerScore = (($bandFollowers/$numUsersDunayGiFollow)*10);
                }else{
                    $followerScore = 0;
                }

                if ($bandVisitCounts != 0) {
                    // $rangeForVisit = $highestVisitCount/5;
                    $visitScore = ($bandVisitCounts/$totalariavisits)*5;
                }else{
                    $visitScore = 0;
                }

                if ($maxSongCount != 0) {
                    $songsplayedScore = ((($songScore/($maxSongCount*10))*100)*0.70);
                }else{
                    $songsplayedScore = 0;
                }

                // echo "album score: ".$albumlikeScore." "."follower score: ".$followerScore." "."visit score: ".(int)$visitScore.""."song score: ".$songsplayedScore."<br>";
                // echo "band: ".$tananbanda->band_name." album score: ".$albumlikeScore." "."follower score: ".$followerScore." "."visit score: ".(int)$visitScore." "."song score: ".$songsplayedScore."<br>";
                $score = $albumlikeScore + $followerScore + (int)$visitScore + $songsplayedScore;

                // echo $score."<br>";
                $bandScore = $score;

                $bandScoreUpdate  = Band::where('band_id',$tananbanda->band_id)->update([
                    'band_score' => $bandScore
                ]);
                // dd($tananbanda->band_score,$tananbanda->band_id);

                
            }

        }

}
