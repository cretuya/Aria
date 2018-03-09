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
use App\Genre;
use App\BandEvent;
use App\Album;
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

    // public function homeshow(){
    //        // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
    //        //  return view('user-profile', compact('userRole'));
        

    //     $user = User::where('user_id',session('userSocial')['id'])->first();

    //     $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
    //     $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
    //     $userBandRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->get();

    //     $articlesfeed = BandArticle::join('preferences','bandarticles.band_id','=','preferences.band_id')->join('bands','preferences.band_id','=','bands.band_id')->join('articles','bandarticles.art_id','=','articles.art_id')->where('user_id',session('userSocial')['id'])->orderBy('created_at','desc')->distinct()->get(['preferences.band_id','art_title','content','band_name','band_pic','articles.created_at']);

    //     $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

    //     // dd($articlesfeed);
    //     $recommend = $this->recommend();
    //     // dd($recommend);
    //     // dd($friends);
    //     return view('home', compact('userHasBand','userBandRole','usersBand','user','articlesfeed', 'recommend','usernotifinvite'));
    // }

    public function feedshow(){
           // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
           //  return view('user-profile', compact('userRole'));
        

        $user = User::where('user_id',session('userSocial')['id'])->first();

        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
        $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
        $userBandRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->get();

        // $articlesfeed = BandArticle::join('preferences','bandarticles.band_id','=','preferences.band_id')->join('bands','preferences.band_id','=','bands.band_id')->join('articles','bandarticles.art_id','=','articles.art_id')->where('user_id',session('userSocial')['id'])->orderBy('created_at','desc')->distinct()->get(['preferences.band_id','art_title','content','band_name','band_pic','articles.created_at']);

        $preferences = Preference::where('user_id', $user->user_id)->get();
        $storeBands = Array();
        foreach($preferences as $preference){
          $getBand = Band::where('band_id', $preference->band_id)->first();
          if($getBand != null){
          array_push($storeBands, $getBand);
          }
          // $event = $getBand->events->toArray();
        }
        $storeEvents = Array();
        foreach ($storeBands as $band) {
          $getEvents = BandEvent::where('band_id', $band->band_id)->get();
          foreach ($getEvents as $event) {
            array_push($storeEvents, $event);
          }
        }
        // dd($storeBands);

        $collection = collect($storeEvents);
        $events = $collection->sortBy('created_at');
        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        $recommendBands = $this->recommendBands();
        $recommendAlbums = $this->recommendAlbums();
        // dd($recommendAlbums);
        return view('feed', compact('userHasBand','userBandRole','usersBand','user','events', 'recommendBands','usernotifinvite', 'recommendAlbums'));
    }

    public function friends(){

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

        $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

        return view('friends', compact('friends','usernotifinvite'));
    }

  public function recommendBands()
  {
        $user = User::where('user_id',session('userSocial')['id'])->first();
        $preferences = Preference::where('user_id', $user->user_id)->whereNotNull('band_id')->get();
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
            if ($get == null)
            {
              return null;
            }
            else{
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
            }
            // dd($genreArray);



              
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
                $compute = null;
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
                    // dd($score);

              return $total;
            }
            else
            {
              $comp = Array();
              $return = Array();

              // $randomBands = Band::inRandomOrder()->get();
              // foreach ($randomBands as $randomBand)
              // {
              //   $compact = array('band' => $randomBand);
              //   array_push($comp, $compact);
              // }
              // return $comp;
              // return $randomBands;

                foreach ($preferences as $preference)
                {
                  array_push($temp, $preference->band->band_id);
                }
                // add in array those bands not in his preference
                foreach ($bands as $band)
                {
                  if (!in_array($band->band_id, $temp))
                  {
                    $comp = array('band' => $band);
                    array_push($return, $comp);
                  }
                }
                return $return;
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

        $playlists = Playlist::join('users','playlists.pl_creator','=','users.user_id')->where('pl_creator', Auth::user()->user_id)->get();
        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();

        // dd($bandsfollowed);
        // dd($usersBand);

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

        $playlists = Playlist::join('users','playlists.pl_creator','=','users.user_id')->where('pl_creator', $uid)->get();
        // dd($bandsfollowed);
        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();
        //nag usab ko diri
        return view('friend-profile', compact('user', 'userHasBand','userBandRole','usersBand','bandsfollowed','bandsfollowedNoGenre','usernotifinvite', 'playlists'));
    }

    public function createplaylist(Request $request)
    {
      $uid = Auth::user()->user_id;
      $title = $request->input('pl_title');
      // $desc = $request->input('pl_desc');
      $image = $request->file('pl_image');

      \Cloudder::upload($image);
      $cloudder=\Cloudder::getResult();
      

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
            // 'pl_desc' => $desc,
            'pl_creator' => $uid,
          ]);
        }
        else
        {
          $create = Playlist::create([
            'pl_title' => $title,
            // 'pl_desc' => $desc,
            'pl_creator' => $uid,
            'image' => $cloudder['url'],
          ]);
        }
      return redirect('/user/profile');
    }
  }

  public function deleteplaylist($id)
  {
    // $pl = Playlist::where('pl_id', $id)->first();

    $delete = Playlist::where('pl_id', $id)->delete();
    return redirect('/user/profile');
    // return response ()->json($id);
  }

  public function editplaylist(Request $request)
  {
    $pl = Playlist::where('pl_id', $request->input('id'))->first();
    return response ()->json($pl);
  }

  public function updateplaylist(Request $request)
  {
    $id = Playlist::where('pl_id', $request->input('pl_id'))->first();
    $title = $request->input('pl_title');
    $desc = $request->input('pl_desc');
    $image = $request->file('pl_image');

    \Cloudder::upload($image);
      $cloudder=\Cloudder::getResult();

    
      $update = Playlist::where('pl_id', $id->pl_id)->update([
        'pl_title' => $title,
        // 'pl_desc' => $desc,
        'image' => $cloudder['url'],
      ]);
      // dd($update);
      return redirect('/user/profile');
    
  }
  public function viewplaylist($id)
  {
    $pl = Playlist::join('users','playlists.pl_creator','=','users.user_id')->where('pl_id', $id)->first();
    $lists = Plist::where('pl_id', $id)->get();
    $user = Auth::user();
   $follower = Preference::where([
          ['user_id' , $user->user_id],
          ['pl_id', $id],
          ])->first();


    $usernotifinvite = UserNotification::where('user_id',session('userSocial')['id'])->join('bands','usernotifications.band_id','=','bands.band_id')->get();

    $recommend = $this->recommendplaylist($id);
    // dd($recommend);

    return view('view-playlist', compact('pl', 'lists', 'rsongs', 'recsongs', 'usernotifinvite', 'recommend', 'follower'));
  }


  public function recommendplaylist($id){
    $family = collect([
    [['genre_id' => 1, 'name' => 'Alternative'],[ 'genre_id' => 16 ,'name' => 'Rock']],
    [['genre_id' => 2, 'name'=> 'Blues'],['genre_id' => 9,'name' => 'Jazz']],
    [['genre_id' => 3,'name' => 'Classical'],['genre_id' => 10, 'name' => 'Opera']],
    [['genre_id' => 4,  'name'=> 'Country'],['genre_id' => 15, 'name'=> 'Reggae']], 
    [['genre_id' => 5, 'name' => 'Dance'],['genre_id' => 7,  'name'=> 'Hiphop']],
    [['genre_id' =>6, 'name'=> 'Electronic'],[ 'genre_id' =>14, 'name'=> 'Rap']],
    [['genre_id' => 8,'name' => 'Inspirational'],[ 'genre_id' =>17, 'name'=> 'Romance']],[['genre_id' => 11, 'name'=> 'Pop' ],['genre_id' => 12, 'name'=> 'Punk']],
    [['genre_id' =>13,'name' =>'R&B'],['genre_id' => 18, 'name'=> 'Soul']]]);

    $user = User::where('user_id',session('userSocial')['id'])->first();
    $lists = Plist::where('pl_id', $id)->get();
    
    if (count($lists) > 0){
      // kwaon ang mga genre sa list nya kwaon ang mga related genres for that certain list
      $genreOfSongsinPlaylist = Array();
      $songsInaPlaylist = Array();
      foreach ($lists as $list)
      {
        array_push($genreOfSongsinPlaylist, $list->genre_id);
        array_push($songsInaPlaylist, $list->song_id);
      }      
        // $test = Song::all();
        // return $test;

      $familyGenres = Array();
      foreach ($genreOfSongsinPlaylist as $key => $value) {
        foreach($family as $fam){
          if ($fam[0]['genre_id'] == $value || $fam[1]['genre_id'] == $value){
            array_push($familyGenres, $fam);
          }
        }
      }
      // dd($familyGenres);

      $songsToRecommend = Array();
      

      foreach ($familyGenres as $key => $value) {
        foreach ($value as $key => $val) {
          $songs = Song::where('genre_id', $val['genre_id'])->get();
          if(count($songs) == null){

          } else {
            foreach($songs as $song){
              if(!in_array($song->song_id, $songsInaPlaylist)){
                 array_push($songsToRecommend, $song);
              }

            }
          }
        }
      }

      if(count($songsToRecommend) == null){
        $storeGenres = Array();
        $topBands = Band::orderBy('weekly_score', 'DESC')->take(6)->get();
        foreach($topBands as $band)
        {
          $bandGenres = $band->bandgenres;
          foreach($bandGenres as $bandGenre)
          {
             array_push($storeGenres, $bandGenre->genre_id);
          }
        }
        $genreIdCount = array_count_values($storeGenres);
          $collection = collect($genreIdCount);
          $chunkedCollectionofGenres = $collection->chunk(3)->first();
          // dd($chunkedCollectionofGenres);
          $familyGenres = Array();
          foreach ($chunkedCollectionofGenres as $key => $value) {
            foreach($family as $fam){
              if ($fam[0]['genre_id'] == $key || $fam[1]['genre_id'] == $key){
                array_push($familyGenres, $fam);
              }
            }
          }

          $songsToRecommend = Array();
          foreach ($familyGenres as $key => $value) {
            foreach ($value as $key => $val) {
              $songs = Song::where('genre_id', $val['genre_id'])->get();
              if(count($songs) == null){

              } else {
                foreach($songs as $song){
                  if(!$lists->contains('song_id', $song->song_id)){
                      array_push($songsToRecommend, $song);
                  }
                }
              }
            }
          }
      }
      // dd($lists);
      return array_unique($songsToRecommend);

    }
    else {
        $preferences = Preference::where('user_id', $user->user_id)->get();

        if (count($preferences) > 0) {
          // get bands genre nya recommend songs based sa genre sa band
          $bands = Array();
          $storeGenres = Array();

          foreach ($preferences as $preference){
            if($preference->band_id != null) {
              $band = Band::where('band_id', $preference->band_id)->first();
              $genresOfBand = BandGenre::where('band_id', $band->band_id)->get(); 
              foreach($genresOfBand as $genreOfBand){
                array_push($storeGenres, $genreOfBand->genre->genre_id);
              }
            }
          }

          $genreIdCount = array_count_values($storeGenres);
          $collection = collect($genreIdCount);
          $chunkedCollectionofGenres = $collection->chunk(3)->first();
          // dd($chunkedCollectionofGenres);
          $familyGenres = Array();
          foreach ($chunkedCollectionofGenres as $key => $value) {
            foreach($family as $fam){
              if ($fam[0]['genre_id'] == $key || $fam[1]['genre_id'] == $key){
                array_push($familyGenres, $fam);
              }
            }
          }

          $songsToRecommend = Array();
          foreach ($familyGenres as $key => $value) {
            foreach ($value as $key => $val) {
              $songs = Song::where('genre_id', $val['genre_id'])->get();
              if(count($songs) == null){

              } else {
                foreach($songs as $song){
                array_push($songsToRecommend, $song);

                }
              }
            }
          }

          if(count($songsToRecommend) == null){
            $storeGenres = Array();
            $topBands = Band::orderBy('weekly_score', 'DESC')->take(6)->get();
            foreach($topBands as $band)
            {
              $bandGenres = $band->bandgenres;
              foreach($bandGenres as $bandGenre)
              {
                 array_push($storeGenres, $bandGenre->genre_id);
              }
            }
            $genreIdCount = array_count_values($storeGenres);
              $collection = collect($genreIdCount);
              $chunkedCollectionofGenres = $collection->chunk(3)->first();
              // dd($chunkedCollectionofGenres);
              $familyGenres = Array();
              foreach ($chunkedCollectionofGenres as $key => $value) {
                foreach($family as $fam){
                  if ($fam[0]['genre_id'] == $key || $fam[1]['genre_id'] == $key){
                    array_push($familyGenres, $fam);
                  }
                }
              }

              $songsToRecommend = Array();
              foreach ($familyGenres as $key => $value) {
                foreach ($value as $key => $val) {
                  $songs = Song::where('genre_id', $val['genre_id'])->get();
                  if(count($songs) == null){

                  } else {
                    foreach($songs as $song){
                      if(!$lists->contains('song_id', $song->song_id)){
                          array_push($songsToRecommend, $song);
                      }
                    }
                  }
                }
              }
          }
     
          return array_unique($songsToRecommend);
        }
        else {

            $storeGenres = Array();
            $topBands = Band::orderBy('weekly_score', 'DESC')->take(6)->get();
            foreach($topBands as $band)
            {
              $bandGenres = $band->bandgenres;
              foreach($bandGenres as $bandGenre)
              {
                 array_push($storeGenres, $bandGenre->genre_id);
              }
            }
            $genreIdCount = array_count_values($storeGenres);
              $collection = collect($genreIdCount);
              $chunkedCollectionofGenres = $collection->chunk(3)->first();
              // dd($chunkedCollectionofGenres);
              $familyGenres = Array();
              foreach ($chunkedCollectionofGenres as $key => $value) {
                foreach($family as $fam){
                  if ($fam[0]['genre_id'] == $key || $fam[1]['genre_id'] == $key){
                    array_push($familyGenres, $fam);
                  }
                }
              }

              $songsToRecommend = Array();
              foreach ($familyGenres as $key => $value) {
                foreach ($value as $key => $val) {
                  $songs = Song::where('genre_id', $val['genre_id'])->get();
                  if(count($songs) == null){

                  } else {
                    foreach($songs as $song){
                      if(!$lists->contains('song_id', $song->song_id)){
                          array_push($songsToRecommend, $song);
                      }
                    }
                  }
                }
              }
          if ($songsToRecommend == null) {
            $songsToRecommend = Song::all();
          }
     
          return array_unique($songsToRecommend);
        }
    }





    // return $storeGenres;
  }

  public function addSongToPlaylist(Request $request){
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


  // public function addtonlist(Request $request)
  // {
  //   $id = $request->input('id');
  //   $pid = $request->input('pid');

  //   $song = Song::where('song_id', $id)->first();
  //   $genre = $song->genre;

  //   if (count($song) > 0)
  //   {
  //     $create = Plist::create([
  //       'genre_id' => $genre->genre_id,
  //       'song_id' => $song->song_id,
  //       'pl_id' => $pid,
  //     ]);
  //   }

  //   return response ()->json(['create' => $create, 'song' => $song]);
  // }

  // public function nrecommend(Request $request)
  // {
  //   $id = $request->input('id');
  //   $pid = $request->input('pid');

  //   $song = Song::where('song_id', $id)->first();
  //   $origs = Song::all();
  //   $recs = Array();
  //   $genres = Array();
  //   $lists = Plist::where('pl_id', $pid)->get();

  //   foreach($origs as $orig)
  //   {
  //     if($lists->contains('song_id', $orig->song_id))
  //     {

  //     }
  //     else
  //     {
  //       $data = array($orig, $orig->genre->genre_name);
  //       array_push($recs, $orig);
  //       // array_push($genres, $orig->genre);
  //     }
  //     // if ($song->song_id == $orig->song_id && $song->genre == $orig->genre)
  //     // {

  //     // }
  //     // else
  //     // {
  //     //   if ($song->genre == $orig->genre)
  //     //   {
  //     //     array_push($recs, $orig);
  //     //   }
  //     // }
  //   }

  //   return response ()->json($recs);
  // }

  // public function addtolist(Request $request)
  // {
  //   $id = $request->input('id');
  //   $pid = $request->input('pid');

  //   $song = Song::where('song_id', $id)->first();
  //   $genre = $song->genre;

  //   if (count($song) > 0)
  //   {
  //     $create = Plist::create([
  //       'genre_id' => $genre->genre_id,
  //       'song_id' => $song->song_id,
  //       'pl_id' => $pid,
  //     ]);
  //   }

  //   return response ()->json(['create' => $create, 'song' => $song]);
  // }  

  // public function listrecommend(Request $request)
  // {
  //   $id = $request->input('id');
  //   $pid = $request->input('pid');

  //   $song = Song::where('song_id', $id)->first();
  //   $origs = Song::all();
  //   $recs = Array();
  //   $lists = Plist::where('pl_id', $pid)->get();

  //   foreach($origs as $orig)
  //   {
  //     if($lists->contains('song_id', $orig->song_id))
  //     {

  //     }
  //     else
  //     {
  //       array_push($recs, $orig);
  //     }
  //     // if ($song->song_id == $orig->song_id && $song->genre == $orig->genre)
  //     // {

  //     // }
  //     // else
  //     // {
  //     //   if ($song->genre == $orig->genre)
  //     //   {
  //     //     array_push($recs, $orig);
  //     //   }
  //     // }
  //   }
  //   // foreach($origs as $orig)
  //   // {
  //   //   if ($song->song_id == $orig->song_id && $song->genre == $orig->genre)
  //   //   {

  //   //   }
  //   //   else
  //   //   {
  //   //     if ($song->genre == $orig->genre)
  //   //     {
  //   //       array_push($recs, $orig);
  //   //     }
  //   //   }
  //   // }

  //   return response ()->json($recs);
  // }

  public function delplsong($sid, $pid)
  {
    $song = PList::where([
    ['song_id', $sid],
    ['pl_id', $pid],
    ])->delete();
    return redirect('playlist/'.$pid);
  }  



  public function recommendAlbums(){
    $user = User::where('user_id',session('userSocial')['id'])->first();
    $getPreferredBands = Preference::where([
            ['user_id' , $user->user_id],
            ['band_id', '!=', null],
            ])->get(); 

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

    if(count($friends) > 0 || count($getPreferredBands) > 0){
      // kwaon ang albums sa mga banda
      $storeAllAlbums = Array();
      foreach ($getPreferredBands as $band){
        $albums = Album::where('band_id', $band->band_id)->get();

        foreach ($albums as $album) {
          array_push($storeAllAlbums, $album);
        }
      }
      // kwaon ang wala pa na like sa user
      $getPreferredAlbums = Preference::where([
            ['user_id' , $user->user_id],
            ['album_id', '!=', null],
            ])->get(); 

      $storeNotPreferredAlbums = Array();

      foreach($storeAllAlbums as $storeAllAlbum){
        if(!$getPreferredAlbums->contains('album_id',$storeAllAlbum->album_id)) {
          array_push($storeNotPreferredAlbums, $storeAllAlbum);
        }
      }
      // if na like na nya tanan albums sa iyang mga banda
      if(count($storeNotPreferredAlbums) > 0){
        //gi kuha ang mga album nga wala niya na like
        // e sort based on release date
        $collect = collect($storeNotPreferredAlbums);
        $sortedAlbums = $collect->sortBy('released_date');
        return $sortedAlbums;
      } else {
        // kwaon ang mga albums nga g like sa iyang mga friends
          $storeFriendsPreferences = Array();
          foreach ($friends as $friend) {
            $getFriendPreferences = Preference::where([
              ['user_id' , $friend->user_id],
              ['album_id', '!=', null],
              ])->get(); 

            foreach($getFriendPreferences as $getFriendPreference){
              array_push($storeFriendsPreferences, $getFriendPreference);
            }
          }
        // kwaon ang mga albums nga na like na nimo
          // dd($storeFriendsPreferences);
          $storeNotSamePreferredAlbums = Array();
          foreach($storeFriendsPreferences as $storeFriendsPreference) {
            if(!$getPreferredAlbums->contains('album_id', $storeFriendsPreference->album_id)){
                  array_push($storeNotSamePreferredAlbums, $storeFriendsPreference->album);
              }
          }
          // if na like na nya tanan album
          if(count($storeNotSamePreferredAlbums) > 0){
            // order by released date
            $collect = collect($storeNotSamePreferredAlbums);
            $sortedAlbums = $collect->sortBy('released_date');
            return $sortedAlbums;

          } else {
            // kwaon ang user's preferred genre
            $storeBandGenres = Array();
            foreach($getPreferredBands as $band){
              $getBand = $band->band;
              $genres = $getBand->bandgenres;
              foreach($genres as $genre){
                array_push($storeBandGenres, $genre);
              }

            }

            $collection = collect($storeBandGenres);
            $uniqueGenres = $collection->unique('genre_id');

            $bands = Band::all();
            $storeBandsWhereSamePrefGenre = Array();
            foreach ($bands as $band) {
              $genres = $band->bandgenres;
              foreach ($genres as $genre) {
                if($uniqueGenres->contains('genre_id', $genre->genre_id)) {
                  array_push($storeBandsWhereSamePrefGenre, $band);
                }
              }
            }
            $collectBands = collect($storeBandsWhereSamePrefGenre);
            $uniqueBands = $collectBands->unique('band_id');

            $storeAlbumsofBand = Array();
            foreach($uniqueBands as $uniqueBand){
              $albums = $uniqueBand->albums;
              foreach ($albums as $album) {
                array_push($storeAlbumsofBand, $album);
              }
            }

            // kwaon ang mga albums nga na like na nya
            $getAlbumsBasedOnGenre = Array();
            foreach ($storeAlbumsofBand as $album) {
              if(!$getPreferredAlbums->contains('album_id', $album->album_id)){
                array_push($getAlbumsBasedOnGenre, $album);
              }
            }

            // if na like na nya tanan albums
            if(count($getAlbumsBasedOnGenre) > 0){
              $collect = collect($getAlbumsBasedOnGenre);
              $sortedAlbums = $collect->sortBy('released_date');
              return $sortedAlbums;
            } else {
            // kwaon ang mga wala sa iyang preferences
              $bands = Band::all();
              $bandPreferences = Preference::where([
                    ['user_id' , $user->user_id],
                    ['band_id', '!=', null],
                    ])->get();
              $albumPreferences = Preference::where([
                    ['user_id' , $user->user_id],
                    ['album_id', '!=', null],
                    ])->get();  
              $getNotPrefBands = Array();
              foreach ($bands as $band) {
                if(!$bandPreferences->contains('band_id', $band->band_id)){
                  array_push($getNotPrefBands, $band);
                }

              }
              
              $storeAlbums = Array();
              foreach ($getNotPrefBands as $getNotPrefBand) {
                $albums = $getNotPrefBand->albums;
                foreach ($albums as $album) {
                  if(!$albumPreferences->contains('album_id', $album->album_id))
                  {
                    array_push($storeAlbums, $album);
                  }
                }
              }
              
              return $storeAlbums;
            }


          }

      }

    } else {
            // kwaon ang mga wala sa iyang preferences
              $bands = Band::all();
              $bandPreferences = Preference::where([
                    ['user_id' , $user->user_id],
                    ['band_id', '!=', null],
                    ])->get();
              $albumPreferences = Preference::where([
                    ['user_id' , $user->user_id],
                    ['album_id', '!=', null],
                    ])->get();  
              $getNotPrefBands = Array();
              foreach ($bands as $band) {
                if(!$bandPreferences->contains('band_id', $band->band_id)){
                  array_push($getNotPrefBands, $band);
                }

              }
              
              $storeAlbums = Array();
              foreach ($getNotPrefBands as $getNotPrefBand) {
                $albums = $getNotPrefBand->albums;
                foreach ($albums as $album) {
                  if(!$albumPreferences->contains('album_id', $album->album_id))
                  {
                    array_push($storeAlbums, $album);
                  }
                }
              }
              
              return $storeAlbums;
    }

  }

  public function followPlaylist(Request $request){
    $user = Auth::user();
    $pid = $request->input('pid');

      $create = Preference::create([
        'user_id' => $user->user_id,
        'pl_id' => $pid,
      ]);

      $followers = count(Preference::where('pl_id' ,$pid)->get());

      $playlist = Playlist::where('pl_id', $pid)->update([
      'followers' => $followers,
      ]);

    return response()->json($followers);
  }

  public function unfollowPlaylist(Request $request){
    $user = Auth::user();
    $pid = $request->input('pid');

      $delete = Preference::where([
      ['user_id' , $user->user_id],
      ['pl_id', $pid],
      ])->delete();

      $followers = count(Preference::where('pl_id' ,$pid)->get());

      $playlist = Playlist::where('pl_id', $pid)->update([
      'followers' => $followers,
      ]);

    return response()->json($followers);
  }

}