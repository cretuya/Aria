<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserNotification;
use App\Band;
use App\Bandmember;
use App\BandGenre;
use App\BandArticle;
use App\Preference;
Use App\Song;
use App\Playlist;
use App\Plist;
use Auth;
use Validator;
class UserController extends Controller
{
    
	public function updateUser(Request $request)
        {
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["address" => "input['users-city']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["contact" => "input['users-contact']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["email" => "input['users-email"]);

            User::where('user_id', session('userSocial')['id'])
                    ->update([
                        "address" => $request->userscity,
                        "contact" => $request->userscontact,
                        "email" => $request->usersemail,
                        "bio" => $request->usersbio
                        ]);

            $usersCity = User::select('address')->where('user_id', session('userSocial')['id'])->first();
            $usersContact = User::select('contact')->where('user_id', session('userSocial')['id'])->first();
            $usersEmail = User::select('email')->where('user_id', session('userSocial')['id'])->first();
            $usersBio = User::select('bio')->where('user_id', session('userSocial')['id'])->first();
            // dd($usersCity->address);
            session(['userSocial_City' => $usersCity->address]);
            session(['userSocial["email"]' => $usersEmail->email]);
            session(['userSocial_Contact' => $usersContact->contact]);
            session(['userSocial_Bio' => $usersBio->bio]);

            return redirect('/user/profile');
        }

    public function feedshow(){
           // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
           //  return view('user-profile', compact('userRole'));
        $socialfriends = session('userSocial')['friends']['data'];
        $friends = Array();
        foreach ($socialfriends as $socialfriend) {
            $friend = $socialfriend['id'];
            $thisuser = User::where('user_id', $friend)->first();

            if(count($thisuser) > 0)
            {
                array_push($friends, $thisuser);
            }
        }

        $user = User::where('user_id',session('userSocial')['id'])->first();

        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
        $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
        $userBandRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->get();

        $articlesfeed = BandArticle::join('preferences','bandarticles.band_id','=','preferences.band_id')->join('bands','preferences.band_id','=','bands.band_id')->join('articles','bandarticles.art_id','=','articles.art_id')->where('user_id',session('userSocial')['id'])->orderBy('created_at','desc')->distinct()->get(['preferences.band_id','art_title','content','band_name','band_pic','articles.created_at']);

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        // dd($articlesfeed);
        $recommend = $this->recommend();
        // dd($recommend);
        return view('feed', compact('userHasBand','userBandRole','usersBand','user', 'friends','articlesfeed', 'recommend','usernotifinvite'));
    }

  public function recommend()
  {
        $user = User::where('user_id',session('userSocial')['id'])->first();
        $preferences = Preference::where('user_id', $user->user_id)->get();
        $temp = Array();
        $get = Array();
        $bands = Band::all();
        $genreArray= Array();
        $data = Array();
        $scores = Array();

        if (count($preferences) > 0)
        {
            // get all preferences
            foreach ($preferences as $preference)
            {
              array_push($temp, $preference->band->band_id);
            }
            // add in array those bands not in his preference
            foreach ($bands as $band)
            {
              if (!in_array($band->band_id, $temp))
              {
                array_push($get, $band);
              }
            }
            // compare genres
            $test = Array();
            foreach($get as $g)
            {
              $genres = $g->bandgenres;
              foreach ($genres as $genre)
              {
                foreach ($preferences as $preference)
                {
                  $pgenres = $preference->band->bandgenres;
                    if ($pgenres->contains('genre_id', $genre->genre_id))
                    {
                      array_push($genreArray, $genre->band->band_id);
                    } 
                }                
              }

              
              $count = count(Band::all()); 
              $weight = $count * 100 * .03;
              // calculate ranking
              $rankpartial = $g->band_id - 1;
              $rankPart = $count - $rankpartial;
              $rtotal = $rankPart / $weight;
              // // calculate popularity
              $pref = Preference::where('band_id', $g->band_id)->get();
              $countPref = count($pref);
              $poppartial = $countPref - 1;
              $popPart = $count - $poppartial;
              $ptotal = $popPart / $weight;

              $compact = array('band_id' => $g->band_id, 'rankscore' => $rtotal, 'followerscore' => $ptotal);

              array_push($scores, $compact);

            }
            
            $total = Array();

            if (count($genreArray) > 0)
            {
              $shows = array_count_values($genreArray);
              foreach ($shows as $key => $value) {
                if ($value > 1)
                {
                  $gband = Band::where('band_id',$key)->first();
                  array_push($data, $gband);

                  $scoreGenre = 4;
                }
                else
                {
                  $gband = Band::where('band_id',$key)->first();
                  array_push($data, $gband);
                  $scoreGenre = 2;
                }
                $k = Band::where('band_id', $key)->first();
                foreach ($scores as $score)
                {
                  if ($key == $score['band_id'])
                  {
                    $compute = $score['rankscore'] + $score['followerscore'] + $scoreGenre;
                  }
                  $insert = array('band' => $k,'total' => $compute);
                }
                array_push($total, $insert);
                // array_push($scoreGenres, $key=>$scoreGenre);
              }
              // $data = array($wholeGenre, $halfGenre);
              // array_push($display, $data);

              return $total;
            }
            else
            {

              $randomBands = Band::inRandomOrder()->get();
              return $randomBands;
            }
        }
        else
        {
          $comp = Array();

          $randomBands = Band::inRandomOrder()->get();
          $randomSongs = Song::inRandomOrder()->get();
          foreach ($randomBands as $randomBand)
          {
            $compact = array('band' => $randomBand);
            array_push($comp, $compact);
          }
          return $comp;
        }

    }
    public function profileshow(){
           // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
           //  return view('user-profile', compact('userRole'));

        $user = User::where('user_id',session('userSocial')['id'])->first();

        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
        $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
        $userBandRole = Bandmember::select('bandrole','band_name')->join('bands','bandmembers.band_id','=','bands.band_id')->where('user_id',session('userSocial')['id'])->get();

        $bandsfollowed = Preference::select('band_name','band_pic','num_followers','genre_name')->join('bands','preferences.band_id','=','bands.band_id')->join('bandgenres','bands.band_id','=','bandgenres.band_id')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->where('user_id',session('userSocial')['id'])->get();

        $bandsfollowedNoGenre = Preference::select('band_name','band_pic','num_followers')->join('bands','preferences.band_id','=','bands.band_id')->where('user_id',session('userSocial')['id'])->get();

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        $playlists = Playlist::where('pl_creator', Auth::user()->user_id)->get();
        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();

        // dd($bandsfollowed);
        // dd($usersBand);
        //nag usab ko diri
            return view('user-profile', compact('userHasBand','userBandRole','usersBand','user','bandsfollowed','bandsfollowedNoGenre','usernotifinvite', 'playlists'));
    }

    public function friendprofile($uid)
    {
        $user = User::where('user_id', $uid)->first();
        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', $uid)->first();
        $userHasBand = Bandmember::where('user_id',$uid)->get();
        $userBandRole = Bandmember::select('bandrole','band_name')->join('bands','bandmembers.band_id','=','bands.band_id')->where('user_id',$uid)->get();

        // dd($uid);

        $bandsfollowed = Preference::select('band_name','band_pic','num_followers','genre_name')->join('bands','preferences.band_id','=','bands.band_id')->join('bandgenres','bands.band_id','=','bandgenres.band_id')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->where('user_id',$uid)->get();

        $bandsfollowedNoGenre = Preference::select('band_name','band_pic','num_followers')->join('bands','preferences.band_id','=','bands.band_id')->where('user_id',$uid)->get();

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();
        // dd($bandsfollowed);
        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();
        //nag usab ko diri
        return view('friend-profile', compact('user', 'userHasBand','userBandRole','usersBand','bandsfollowed','bandsfollowedNoGenre','usernotifinvite'));
    }

    public function createplaylist(Request $request)
    {
      $uid = Auth::user()->user_id;
      $title = $request->input('pl_title');
      $desc = $request->input('pl_desc');
      $image = $request->file('image');
      // dd($uid);
      $rules = new Playlist;
      $validator = Validator::make($request->all(), $rules->rules);
      if ($validator->fails())
      {
          return redirect('/user/profile')->withErrors($validator)->withInput();
      }
      else
      {

        if ($image == null)
        {
          $create = Playlist::create([
            'pl_title' => $title,
            'pl_desc' => $desc,
            'pl_creator' => $uid,
          ]);
        }
        else
        {
          $create = Playlist::create([
            'pl_title' => $title,
            'pl_desc' => $desc,
            'pl_creator' => $uid,
            'image' => $image,
          ]);
        }
      return redirect('/user/profile');
    }
  }

  public function viewplaylist($id)
  {
    $pl = Playlist::where('pl_id', $id)->first();
    $lists = Plist::where('pl_id', $id)->get();
    $rsongs = Song::inRandomOrder()->get();


    return view('view-playlist', compact('pl', 'lists', 'rsongs'));
  }

  public function addtonlist(Request $request)
  {
    $id = $request->input('id');
    $pid = $request->input('pid');

    $song = Song::where('song_id', $id)->first();
    $genre = $song->genre;

    if (count($song) > 0)
    {
      $create = Plist::create([
        'genre_id' => $genre->genre_id,
        'song_id' => $song->song_id,
        'pl_id' => $pid,
      ]);
    }

    return response ()->json(['create' => $create, 'song' => $song]);
  }

  public function nrecommend(Request $request)
  {
    $id = $request->input('id');
    $pid = $request->input('pid');

    $song = Song::where('song_id', $id)->first();
    $origs = Song::all();
    $recs = Array();

    foreach($origs as $orig)
    {
      if ($song->song_id == $orig->song_id && $song->genre == $orig->genre)
      {

      }
      else
      {
        if ($song->genre == $orig->genre)
        {
          array_push($recs, $orig);
        }
      }
    }

    return response ()->json($recs);
  }

}