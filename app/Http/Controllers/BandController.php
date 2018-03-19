<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Album;
use App\Album_Contents;
use App\Article;
use App\Band;
use App\BandGenre;
use App\BandArticle;
use App\Bandmember;
use App\BandVideo;
use App\Genre;
use App\BandEvent;
use App\Song;
use App\SongsPlayed;
use App\User;
use App\Visit;
use App\UserNotification;
use App\Preference;
use \Session;
use Auth;   
use Laravel\Socialite\Facades\Socialite;
use Validator;

class BandController extends Controller
{
    public function index($name)
    {

        $bands = Auth::user()->bandmember;

        $band = Band::where('band_name' ,$name)->first();
        $videos = BandVideo::where('band_id', $band->band_id)->get();
        $albums = Album::where('band_id', $band->band_id)->get();
        $articles = BandArticle::where('band_id' , $band->band_id)->get();
        $events = BandEvent::where('band_id' , $band->band_id)->get();
        $genres = Genre::all();

        $songs = array();
        foreach ($albums as $album)
        {
            array_push($songs, Song::where('album_id', $album->album_id)->get());
        }

        $bandmembers = Bandmember::where('band_id',$band->band_id)->get();
        $BandDetails = Band::where('band_id', $band->band_id)->first();

        $bandGenreSelected = BandGenre::where('band_id', $band->band_id)->get();
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        if ($bandmembers->contains('user_id',session('userSocial')['id'])) {
            return view('dashboard-band' , compact('band','videos', 'albums', 'articles', 'events', 'genres', 'songs', 'bandmembers','BandDetails','bandGenreSelected','usernotifinvite'));
        }
        else
        {
            return redirect('/home');
        }
        
    }

    public function createBand(Request $request)
    {
        $name = $request->input('band_name');
        $role = $request->input('band_role_create');
        $zero = 0;

        $genre1 = $request->input('genre_select_1');
        $genre2 = $request->input('genre_select_2');

        // $role = $request->input('band_pic');

        date_default_timezone_set("Asia/Manila");
        $dateToday = date('Y-m-d');

        // dd($dateToday);
        $rules = new Band;
        $validator = Validator::make($request->all(), $rules->rules);
        if ($validator->fails())
        {
            return redirect('/feed')->withErrors($validator)->withInput();
        }
        else
        {
            $create = Band::create([
                'band_name' => $name,
                'band_pic' => 'dummy-pic.jpg',
                'band_desc' => $request->input('bandDescr'),
                'num_followers' => $zero,
                'visit_counts' => $zero,
                'weekly_score' => $zero,
                'band_score' => $zero,
                'scored_updated_date' => $dateToday
            ]);


            $bandmember = Bandmember::create([
                'band_id' => $create->id,
                'user_id' => session('userSocial')['id'],
                'bandrole' => $role
                // 'band_desc' => $desc,
            ]);

            $bgenre1 = BandGenre::create([
                'band_id' => $create->id,
                'genre_id' => $genre1
            ]);

            $bgenre2 = BandGenre::create([
                'band_id' => $create->id,
                'genre_id' => $genre2
            ]);

            return redirect('/'.$create->band_name.'/manage');
        }

    }

    public function followBand(Request $request)
    {
        $band = Band::where('band_id', $request->input('id'))->first();
        $genre = BandGenre::where('band_id',$band->band_id)->get();
        $followers = $band->num_followers;
        $newfollowers = $followers + 1;

        if (count($band) > 0)
        {
            $update = Band::where('band_id', $band->band_id)->update([
                'num_followers' => $newfollowers
             ]);

            $create = Preference::create([
                'user_id' => Auth::user()->user_id,
                'band_id' => $band->band_id,
            ]);
            //nag usab ko diri
            $newband = $create->band;

            $preference = Preference::where('band_id', $band->band_id)->get();
            $followers = count($preference);            
        }

        $this->scoringfunc();
        return response ()->json(['band' => $newband, 'preference' => $create, 'followers' => $followers]);

    }
    public function unfollowBand(Request $request)
    {
        // $user = User::where('user_id' , $request->input('uid'))->first();


        $follower = Preference::where([
            ['user_id' , $request->input('uid')],
            ['band_id', $request->input('bid')],
            ])->first();

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

            $preference = Preference::where('band_id', $band->band_id)->get();
            $followers = count($preference);
        }

        $this->scoringfunc();
        return response ()->json(['band' => $newband, 'preference' => $follower, 'followers' => $followers]);
    }

    public function search(Request $request){
        // dd($request);s
        // dd($request->term);
        $terms = $request->term;
        // dd($terms);
        $user = User::where('fullname', 'LIKE', '%'.$terms.'%')->get();
        // dd($user);
        if (count($user) == 0) {
            $searchResult[] = 'No users found';
        }
        else{
            foreach ($user as $users) {
                $searchResult[] = ['value'=>$users->fullname, 'id'=>$users->user_id];
            }
        }
        return response()->json($searchResult);
    }

    // public function listMembers()
    // {
    //  $BandMembers = Bandmember::join('bands', 'bands.band_id', '=', 'bandmembers.band_id')->join('users', 'users.user_id', '=', 'bandmembers.user_id')->select('users.*', 'users.fullname', 'bandmembers.bandrole')->get();

    //  return view('dashboard-band', compact($BandMembers));
    // }

    // public function userBands(){
    //     $userbands = Bands::join('users', 'bands.user_id', '=', 'users.user_id')->select('users.*', 'bands.band_name')->get();
    //     Session::put('userBands', $userbands);
    //     dd($userbands);
    // }

    public function editBand(Request $request)
    {

        // dd($request);
        Band::where('band_id', $request->bandId)->update([
                "band_name" => $request->bandName,
                "band_desc" => $request->bandDesc
                ]);
        $band_Name = $request->bandName;

        $genreArrayChecked = Input::get('genres');
        // dd($genreArrayChecked[0]);

        $bandhasGenre = BandGenre::where('band_id', $request->bandId)->get();

        if(count($bandhasGenre) >= 2){
            BandGenre::where('band_id', $request->bandId)->delete();

            BandGenre::create([
                'band_id' => $request->bandId,
                'genre_id' => $genreArrayChecked[0]
                ]);

            BandGenre::create([
                'band_id' => $request->bandId,
                'genre_id' => $genreArrayChecked[1]
                ]);
            
        }else{
            BandGenre::create([
                'band_id' => $request->bandId,
                'genre_id' => $genreArrayChecked[0]
                ]);

            BandGenre::create([
                'band_id' => $request->bandId,
                'genre_id' => $genreArrayChecked[1]
                ]);
        }

        

        return redirect('/'.$band_Name.'/manage');
    }

    public function addMemberstoBand(Request $request)
    {
        $memberNameInput = $request->input('add-band-member-name');
            $roleInput = $request->input('add-band-member-role');
            
            $bandmember = Bandmember::create([
                '' => $memberNameInput,
                'user_id' => $findMembertoAdd,
                'role' => $role
            ]);
    }

    public function editBandPic(Request $request)
    {


    	$bandName = $request->input('bandName');
    	$bandpic = $request->file('bandPic');
    	$bandID = $request->input('bandId');
        \Cloudder::upload($bandpic);
        $cloudder=\Cloudder::getResult();
        // $bandPicPath = $this->addPathBandPic($bandpic,$bandID,$bandName);

        Band::where('band_id', $bandID)->update([
            "band_pic" => $cloudder['url'],
            ]);

        return redirect('/'.$bandName.'/manage');
    }

    public function editBandCoverPic(Request $request)
    {


        $bandName = $request->input('bandName');
        $bandcoverpic = $request->file('bandCoverPic');
        $bandID = $request->input('bandId');
        \Cloudder::upload($bandcoverpic);
        $cloudder=\Cloudder::getResult();

        Band::where('band_id', $bandID)->update([
            "band_coverpic" => $cloudder['url'],
            ]);

        return redirect('/'.$bandName.'/manage');
    }

    public function show($name)
    {
        $band = Band::where('band_name', $name)->first();
        $genres = $band->bandgenres;
        $articles = $band->bandarticles;
        $videos = BandVideo::where('band_id', $band->band_id)->get();
        $albums = Album::where('band_id', $band->band_id)->get();
        $events = BandEvent::where('band_id', $band->band_id)->get();

        $follower = Preference::where([
            ['user_id' , Auth::user()->user_id],
            ['band_id', $band->band_id],
            ])->first();
        $preference = Preference::where('band_id', $band->band_id)->get();
        $followers = count($preference);
        // if ($follower > 0)
        // {
            // return view('band-profile', compact('band', 'genres', 'articles', 'follower'));
        // }
        // else
        // {

        $visitcount = $band->visit_counts;
        $newcount = $visitcount + 1;

        $update = Band::where('band_id', $band->band_id)->update([
            'visit_counts' => $newcount
        ]);

        $createVisit = Visit::create([
                'user_id' => session('userSocial')['id'],
                'band_id' => $band->band_id
                ]);

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        // dd($usernotifinvite);
        // dd($band->members);
        $this->scoringfunc();
            return view('band-profile', compact('band', 'genres', 'articles', 'videos', 'albums' , 'events', 'follower', 'followers','usernotifinvite'));
        // }

    }

    public function addPathBandPic($bandpicture, $bandID, $bandName){
        if ($bandpicture != null)
        {           
                $extension = $bandpicture->getClientOriginalExtension();
                if($extension == "png" || $extension == "jpg" || $extension == "jpeg")
                {
                    
                    $destinationPath = public_path().'/assets/'.$bandID.' - '.$bandName.'/';
                    $picname = $bandpicture->getClientOriginalName();
                    $bandpicture = $bandpicture->move($destinationPath, $picname);
                    $bandpicture = $picname;
                }
        }
        else
        {
            $bandpicture = "";
        }
        return $bandpicture;
    }

    // public function visitCount(Request $request)
    // {
    //     $band = Band::where('band_id', $request->input('id'))->first();
    //     $visitcount = $band->visit_counts;
    //     $newcount = $visitcount + 1;

    //     $update = Band::where('band_id', $band->band_id)->update([
    //         'visit_counts' => $newcount
    //     ]);

    //     return response ()->json($band);
    // }

    public function scoringfunc(){

            $bands = Band::all();
            // $albums = Album::all();
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
                    $distinctusersalbum = Preference::distinct()->where('album_id',$album->album_id)->get(['user_id']);
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

                // echo count($distinctusersalbum)." ".$tananbanda->band_name."<br>";
                // echo $distinctusersalbum." ".$tananbanda->band_name."<br>";

                // $highestVisitCount = max($visitcountArray);
                // echo $highestVisitCount."<br>";
                // echo $numUsersDunayGiLike."like<br>";
                // echo $numUsersDunayGiFollow."follow<br>";
                // echo $totalariavisits." ang total distinct users naka visit sa aria page after login<br>";
                // echo $bandVisitCounts." distinct visit counts ".$tananbanda->band_name."<br>";
                if ($numUsersDunayGiLike != 0) {
                    $albumlikeScore = ((count($distinctusersalbum)/$numUsersDunayGiLike)*15);
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
                
                $score = $albumlikeScore + $followerScore + (int)$visitScore + $songsplayedScore;

                // echo $score."<br>";
                $bandScore = $score;

                // echo "band: ".$tananbanda->band_name." album score: ".$albumlikeScore." "."follower score: ".$followerScore." "."visit score: ".(int)$visitScore." "."song score: ".$songsplayedScore." band score: ".$bandScore."<br>";

                $bandScoreUpdate  = Band::where('band_id',$tananbanda->band_id)->update([
                    'band_score' => $bandScore
                ]);
                // dd($tananbanda->band_score,$tananbanda->band_id);

                
            }

        }

}
