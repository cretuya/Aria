<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Album;
use App\Album_Contents;
use App\Article;
use App\Band;
use App\BandGenre;
use App\BandArticle;
use App\Bandmember;
use App\BandVideo;
use App\BandEvent;
use App\Genre;
use App\Song;
use App\User;
use App\Preference;
use App\SongsPlayed;
use \Session;
use Auth;	
use Laravel\Socialite\Facades\Socialite;

class BandController extends Controller
{
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

		$uid = $request->input('user_id');
		$user = User::where('user_id', $uid)->first();

		if(count($user) > 0)
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
                'user_id' => $uid,
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
			return response ()->json(['band' => $create ,'member' => $bandmember , 'genre1' => $bgenre1 , 'genre2' => $bgenre2]);		
		}
		else
		{
			return response() ->json(['message', 'User not found.']);
		}

		// return redirect('/'.$create->band_name.'/manage');
		
	}

	// public function followBand($bname)
	// {
	// 	$band = Band::where('band_name', $bname)->first();
	// 	return response ()->json($band);

	// }

	public function search(Request $request){
		// dd($request);
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
	// 	$BandMembers = Bandmember::join('bands', 'bands.band_id', '=', 'bandmembers.band_id')->join('users', 'users.user_id', '=', 'bandmembers.user_id')->select('users.*', 'users.fullname', 'bandmembers.bandrole')->get();

    //  return view('dashboard-band', compact($BandMembers));
	// }

    // public function userBands(){
    //     $userbands = Bands::join('users', 'bands.user_id', '=', 'users.user_id')->select('users.*', 'bands.band_name')->get();
    //     Session::put('userBands', $userbands);
    //     dd($userbands);
    // }

    public function getBand(Request $request)
    {

    	// dd($request);
    	$editbandDetails = Band::where('band_id', $request->input('band_id'))->first();

    	// $genreArrayChecked = Input::get('genres');
    	// // dd($genreArrayChecked[0]);

    	$bandhasGenres = BandGenre::where('band_id', $request->input('band_id'))->get();
    	$genres = Array();

    	foreach ($bandhasGenres as $bandhasGenre)
    	{
    		$genre = Genre::where('genre_id', $bandhasGenre->genre_id)->first();
    		array_push($genres, $genre);
    	}
    	// if(count($bandhasGenre) == 2){
    	// 	BandGenre::where('band_id', $request->input('band_id'))->delete();
     //    }else{
    	// 	$bandGenre1 = BandGenre::create([
    	// 		'band_id' => $request->bandId,
    	// 		'genre_id' => $genreArrayChecked[0]
    	// 		]);

    	// 	$bandGenre2 = BandGenre::create([
    	// 		'band_id' => $request->bandId,
    	// 		'genre_id' => $genreArrayChecked[1]
    	// 		]);
    	// }

    	// return redirect('/'.$band_Name.'/manage');
    	return response ()->json(['band' => $editbandDetails ,'bandgenre' => $bandhasGenre, 'genre' => $genres]);
    }

   //  public function updateBand(Request $request)
   //  {
   //  	$genresArrayChecked = $request->get('genre_id');
   //  	$updates = Array();
   //  	$band = Band::where('band_id', $request->input('band_id'))->update([
   //  		'band_name' => $request->input('band_name'),
   //  		'band_desc' => $request->input('band_desc'),
   //  		'band_pic'  => $request->input('band_pic'),
   //  	]);
   //  	if (count($genresArrayChecked) > 0)
   //  	{
			// $bandgenres = BandGenre::where('band_id' , $request->input('band_id'))->delete();
			
			// foreach ($genresArrayChecked as $genreArrayChecked)
	  //   	{
	  //   		$update = BandGenre::where('genre_id', $genreArrayChecked)->update([
	  //   			'band_id' => $band->id,
	  //   			'genre_id' => $genreArrayChecked,
	  //   		]);
	  //   		array_push($updates, $update);
	  //   	}
   //  	}
   //  	return response()->json(['band' => $band, 'genre' => $updates]);

   //  }

    public function addMemberstoBand(Request $request)
    {
    	$memberNameInput = $request->input('add-band-member-name');
		$roleInput = $request->input('add-band-member-role');
			
			$bandmember = Bandmember::create([
				'' => $memberNameInput,
				'user_id' => $findMembertoAdd,
				'role' => $role
			]);

		return response ()->json($bandmember);
    }

    public function editBandPic(Request $request)
    {

        $bandName = $request->bandName;
        $bandpic = $request->file('bandPic');
        $bandID = $request->input('bandId');
        \Cloudder::upload($bandpic);
        $cloudder=\Cloudder::getResult();
        // $bandPicPath = $this->addPathBandPic($bandpic,$bandID,$bandName);

        $update = Band::where('band_id', $bandID)->update([
            "band_pic" => $cloudder['url'],
            ]);


    	// return redirect('/'.$bandName.'/manage');
    	return response ()->json($update);
    }

    public function show($name)
    {
    	$band = Band::where('band_name', $name)->first();
    	// dd($band);
    	// return view('band-profile', compact('band'));
    	return response ()->json($band);
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
        // return $bandpicture;
        return response ()->json($bandpicture);
    }
	public function followBand(Request $request)
	{
		$user = $request->input('user_id');
		$band = Band::where('band_id', $request->input('band_id'))->first();
        $followers = $band->num_followers;
        $newfollowers = $followers + 1;

        if (count($band) > 0)
        {
            $update = Band::where('band_id', $band->band_id)->update([
                'num_followers' => $newfollowers
             ]);

            $create = Preference::create([
                'user_id' => $user,
                'band_id' => $band->band_id,
            ]);
            $newband = $create->band;
        }
        return response ()-> json($newfollowers);

	}
    public function unfollowBand(Request $request)
    {
        // $user = User::where('user_id' , $request->input('uid'))->first();

    	$user = $request->input('user_id');
        $follower = Preference::where([
            ['user_id' , $user],
            ['band_id', $request->input('band_id')],
            ])->first();

        if (count($follower) > 0)
        {   
            $band = Band::where('band_id' , $request->input('band_id'))->first();            
            $numfollow = $band->num_followers;
            $newfollowers = $numfollow - 1;
            $update =  Band::where('band_id', $request->input('band_id'))->update([
            'num_followers' => $newfollowers
            ]);

            $delete = Preference::where([
            ['user_id' , $user],
            ['band_id', $request->input('band_id')],
            ])->delete();
            $newband = $follower->band;
        }

        return response ()-> json($newfollowers);
    }
    public function visitCount(Request $request)
    {
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $visitcount = $band->visit_counts;
        $newcount = $visitcount + 1;

        $update = Band::where('band_id', $band->band_id)->update([
            'visit_counts' => $newcount
        ]);

        return "true";
    }
    public function bands()
    {
        $bands = Band::all();

        return response()->json($bands);
    }

    public function getEvents(){
        $events = BandEvent::all();

        return response ()-> json($events);
    }

    public function addBandCoverPhoto(Request $request){
        $bandName = $request->bandName;
            $bandpic = $request->file('bandPic');
            $bandID = $request->input('bandId');
            \Cloudder::upload($bandpic);
            $cloudder=\Cloudder::getResult();

            $update = Band::where('band_id', $bandID)->update([
            "band_coverpic" => $cloudder['url'],
            ]);

    }

    public function addEvent(Request $request){
        $bandID = $request->input('band_id');
        $eventName = $request->input('event_name');
        $date = $request->input('event_date');
        $time = $request->input('event_time');
        $eventVenue = $request->input('event_venue');
        $eventLocation = $request->input('event_location');
        $eventDate = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
    
        $create = BandEvent::create([
            'band_id' => $bandID,
            'event_name' => $eventName,
            'event_date' => $eventDate,
            'event_time' => $time,
            'event_venue' => $eventVenue,
            'event_location' => $eventLocation,
        ]);

        return response() -> json($create);

    }

    public function getBandGenres(){
        $bandGenres = BandGenre::all();

        return response()->json($bandGenres);
    }

    public function scoringfunc(){

            $bands = Band::all();
            $albums = Album::all();
            $maxUseralbumlikes = Preference::distinct()->where('album_id','!=',null)->get(['user_id']);
            $numUsersDunayGiLike = count($maxUseralbumlikes);
            $maxvisitcount = 0;
            $maxUserfollowers = Preference::distinct()->where('band_id','!=',null)->get(['user_id']);
            $numUsersDunayGiFollow = count($maxUserfollowers);
            $ariavisits = Visit::distinct('user_id')->where('aria_visits','!=',null)->get();
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
