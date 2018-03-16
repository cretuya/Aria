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
use App\SongsPlayed;
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

    public function recommendBands(){
      $user = Auth::user();

      // get all songs nga g paminaw sa user and group same song genre 
      $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

      $prefBands = Preference::where([
      ['user_id' , $user->user_id],
      ['band_id', '!=', 'null'],
      ])->get();

      // check if user naay preference
      if($getSongPlays != null) {

          $getSongs = Array();

          foreach($getSongPlays as $getSongPlay){
            $getGenre = $getSongPlay->songs->genre_id;
            $array = array('song_id' => $getSongPlay->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlay->category);
            array_push($getSongs, $array);
          }

          $collectSongs = collect($getSongs);
          $groupedSongsbyGenre = $collectSongs->groupBy('genre_id');

          // add corresponding score to each genre
          $genreScores = Array();

          foreach ($groupedSongsbyGenre as $key => $value) {
            $sumForCertainGenre = $value->sum('category');
            $scoreForCertainGenre = $sumForCertainGenre / count($value);
            $arrayScore = array('genre_id' => $key, 'score' => $scoreForCertainGenre);
            array_push($genreScores, $arrayScore);
          }
      
          $bands = Band::all();
          $notPrefBands = Array();
          $getGenresofNotPrefBands = Array();

          foreach($bands as $band){
            if(!$prefBands->contains('band_id', $band->band_id)){
              array_push($notPrefBands, $band);
              // get genres of not preferred bands
              $bandgenres = $band->bandgenres;
              foreach($bandgenres as $bandgenre){
                array_push($getGenresofNotPrefBands, $bandgenre);
              }
            }
          }

          $storeBandsBasedOnSameGenres = Array();
          // get bands with same genre
          foreach ($genreScores as $genreScore) {
            foreach ($getGenresofNotPrefBands as $getGenre) {
              if($genreScore['genre_id'] == $getGenre->genre_id){
                array_push($storeBandsBasedOnSameGenres, $getGenre->band);
              }
            }
          }

          if ($storeBandsBasedOnSameGenres != null){
            $collectBands = collect($storeBandsBasedOnSameGenres);
            $rankBands = $collectBands->sortByDesc('band_score')->take('5');

            return $rankBands;

          } else {
            // get not followed bands and rank bands
              $bands = Band::all();
              $notPrefBands = Array();

              foreach($bands as $band){
                if(!$prefBands->contains('band_id', $band->band_id)){
                  array_push($notPrefBands, $band);
                }
              }

              $collectBands = collect($notPrefBands);
              $rankBands = $collectBands->sortByDesc('band_score')->take('5');
              return $rankBands;
          }


    } else {
            // get not followed bands and rank bands
              $bands = Band::all();
              $notPrefBands = Array();

              foreach($bands as $band){
                if(!$prefBands->contains('band_id', $band->band_id)){
                  array_push($notPrefBands, $band);
                }
              }

              $collectBands = collect($notPrefBands);
              $rankBands = $collectBands->sortByDesc('band_score')->take('5');
              return $rankBands;
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
      $user = Auth::user();

      // get all songs nga g paminaw sa user and group same song genre 
      $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

      // get friends
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

      // check if user naay friends
      if($friends != null) {

          $getSongs = Array();

          foreach($getSongPlays as $getSongPlay){
            $getGenre = $getSongPlay->songs->genre_id;
            $array = array('song_id' => $getSongPlay->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlay->category);
            array_push($getSongs, $array);
          }

          $collectSongs = collect($getSongs);
          $groupedSongsbyGenre = $collectSongs->groupBy('genre_id');

          // add corresponding score to each genre
          $genreScores = Array();

          foreach ($groupedSongsbyGenre as $key => $value) {
            $sumForCertainGenre = $value->sum('category');
            $scoreForCertainGenre = $sumForCertainGenre / count($value);
            $arrayScore = array('genre_id' => $key, 'score' => $scoreForCertainGenre);
            array_push($genreScores, $arrayScore);
          }
          $collectGenreScores = collect($genreScores);
          $totalGenreScore = $collectGenreScores->sum('score'); // add genre scores

          // get genre score of each friend
          $getGenreScoresofFriends = Array();

          foreach ($friends as $friend) {
              $getSongPlaysofFriend = SongsPlayed::where('user_id', $friend->user_id)->get();
              $getSongsofFriend = Array();

              foreach($getSongPlaysofFriend as $getSongPlayofFriend){
                $getGenre = $getSongPlayofFriend->songs->genre_id;
                $array = array('song_id' => $getSongPlayofFriend->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlayofFriend->category);
                array_push($getSongsofFriend, $array);
              }

              $collectSongs = collect($getSongsofFriend);
              $groupedSongsbyGenre = $collectSongs->groupBy('genre_id');

              // add corresponding score to each genre
              $genreScores = Array();

              foreach ($groupedSongsbyGenre as $key => $value) {
                $sumForCertainGenre = $value->sum('category');
                $scoreForCertainGenre = $sumForCertainGenre / count($value);
                $arrayScore = array('genre_id' => $key, 'score' => $scoreForCertainGenre);
                array_push($genreScores, $arrayScore);
              }
              $collectGenreScores = collect($genreScores);
              $totalGenreScoreofFriend = $collectGenreScores->sum('score'); // add genre scores
              // get difference of my genre score and my friend's genre score
              $difference = $totalGenreScore - $totalGenreScoreofFriend;
              if($totalGenreScoreofFriend != null) {
                $array = array('user_id' => $friend->user_id, 'total' => $totalGenreScoreofFriend, 'difference' => $difference);
                array_push($getGenreScoresofFriends, $array);
              }


          }          
          // ranked friends based on score genres
          $collectGenreScoresofFriends = collect($getGenreScoresofFriends);
          $sortGenreScores = $collectGenreScoresofFriends->sortBy('difference');

          // get ranked friends most played
          $category1 = 10;
          $category2 = 6;
          $category3 = 2;
          $getCorScore = Array();
          $getCorScoreofFriends = Array();
          foreach ($sortGenreScores as $sortGenreScore) {
            $plays = SongsPlayed::where('user_id', $sortGenreScore['user_id'])->get();
            $collectPlays = collect($plays);
            $groupBySongIds = $collectPlays->groupBy('song_id');
            foreach ($groupBySongIds as $key => $value) {
              $countforcat1 = $value->where('category', 1);
              $countforcat2 = $value->where('category', 2);
              $countforcat3 = $value->where('category', 3);

              $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
              $array = array('song_id' => $key, 'scoreforsong' => $getScoreforCats);
              array_push($getCorScore, $array);
            }

            array_push($getCorScoreofFriends, $getCorScore);
          }          

          // sorted songs
          $songs = Array();
          foreach ($getCorScoreofFriends as $key => $value) {
            $collectValues = collect($value);
            $sorts = $collectValues->sortByDesc('scoreforsong');
            foreach ($sorts as $sort) {
            $sortedSongs = Song::where('song_id', $sort['song_id'])->first();
            array_push($songs, $sortedSongs);

            }
          }

          $filteredSongs = Array();

          $lists = Plist::where('pl_id', $id)->get();
          // remove songs already in the playlist
          foreach ($songs as $song) {
            if(!$lists->contains('song_id', $song->song_id)){
              array_push($filteredSongs, $song);
            }
          }

          return $filteredSongs;

       } else {
          if($getSongPlays == null){
                // get songs of the  top bands
                $songPlays = SongsPlayed::all();
                $bands = Band::orderBy('band_score', 'DESC')->take('5')->get();

                $storePlays = Array();
                foreach($songPlays as $songPlay){
                  $band = $songPlay->songs->album->band->band_id;
                  if($bands->contains('band_id', $band)){
                    array_push($storePlays, $songPlay);
                  }
                }
                  // remove songs nga naa sa playlist
                  $showPlays = Array();
                  foreach ($storePlays as $storePlay) {
                    if(!$lists->contains('song_id', $storePlay->songs->song_id)){
                      $array = array('band_id' => $storePlay->songs->album->band->band_id, 'song_id' => $storePlay->songs->song_id, 'category' => $storePlay['category']);
                      array_push($showPlays, $array);
                    }
                  }

                  // compute scores of the songs of each band
                  $collectBands = collect($showPlays);
                  $groupByBandIds = $collectBands->groupBy('band_id');
                  $category1 = 10;
                  $category2 = 6;
                  $category3 = 2;
                  $getCorScore = Array();

                  // get most played music of bands
                  foreach ($groupByBandIds as $bkey => $bvalue) {
                    $groupBySongIds = $bvalue->groupBy('song_id');

                    foreach ($groupBySongIds as $key => $value) {
                          $countforcat1 = $value->where('category', 1);
                          $countforcat2 = $value->where('category', 2);
                          $countforcat3 = $value->where('category', 3);

                          $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
                          $array = array('song_id' => $key, 'scoreforsong' => $getScoreforCats, 'band_id' => $bkey);
                          array_push($getCorScore, $array);
                    }
                    
                  }


                  // sort songs based on score
                  $collectScores = collect($getCorScore);
                  $sorts = $collectScores->sortByDesc('scoreforsong');

                  // display songs
                  $displaySongs = Array();
                  foreach ($sorts as $sort) {
                      $song = Song::where('song_id', $sort['song_id'])->first();
                      array_push($displaySongs, $song);
                  }
                  
                  return $displaySongs;

          } else {
                $user = Auth::user();

                // get all songs nga g paminaw sa user and group same song genre 
                $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

                $prefBands = Preference::where([
                ['user_id' , $user->user_id],
                ['band_id', '!=', 'null'],
                ])->get();

                    $getSongs = Array();

                    foreach($getSongPlays as $getSongPlay){
                      $getGenre = $getSongPlay->songs->genre_id;
                      $array = array('song_id' => $getSongPlay->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlay->category);
                      array_push($getSongs, $array);
                    }

                    $collectSongs = collect($getSongs);
                    $groupedSongsbyGenre = $collectSongs->groupBy('genre_id');

                    // add corresponding score to each genre
                    $genreScores = Array();

                    foreach ($groupedSongsbyGenre as $key => $value) {
                      $sumForCertainGenre = $value->sum('category');
                      $scoreForCertainGenre = $sumForCertainGenre / count($value);
                      $arrayScore = array('genre_id' => $key, 'score' => $scoreForCertainGenre);
                      array_push($genreScores, $arrayScore);
                    }

                    // get top ranked bands
                    $topbands = Band::orderBy('band_score', 'DESC')->take('5')->get();
                    $collectGenreScores = collect($genreScores);

                    // store all sames genres of top bands
                    $storeBandGenres = Array();
                    foreach ($topbands as $topband) {
                      $bandgenres = $topband->bandgenres;
                      foreach ($bandgenres as $bandgenre) {
                        if($collectGenreScores->contains('genre_id', $bandgenre->genre_id)){
                            array_push($storeBandGenres, $bandgenre);
                        }
                      }
                    }
                    // get songs with same genre
                    $getSongswSameGenres = Array();
                    foreach ($storeBandGenres as $storeBandGenre) {
                      $songs = Song::where('genre_id', $storeBandGenre->genre_id)->get();
                      foreach ($songs as $song) {
                        array_push($getSongswSameGenres, $song);
                      }
                    }
                    // sort by songsPlayed
                    $getAllSongPlays = Array();
                    foreach ($getSongswSameGenres as $song) {
                      $songplays = SongsPlayed::where('song_id', $song->song_id)->get();
                      foreach ($songplays as $songplay) {
                          array_push($getAllSongPlays, $songplay);
                      }
                    }
                    $collectSongPlays = collect($getAllSongPlays);
                    $groupBySids = $collectSongPlays->groupBy('song_id');

                    // calculate the scores
                    $scoreBasedOnCategory = Array();
                    foreach ($groupBySids as $key => $value) {
                          $countforcat1 = $value->where('category', 1);
                          $countforcat2 = $value->where('category', 2);
                          $countforcat3 = $value->where('category', 3);

                          $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
                          $array = array('song_id' => $key, 'scoreforsong' => $getScoreforCats);
                          array_push($scoreBasedOnCategory, $array);

                    }
                    
                    // sort Calculated songs
                    $collectNewSongs = collect($scoreBasedOnCategory);
                    $sortNewSongs = $collectNewSongs->sortByDesc('scoreforsong');

                    // display songs
                    $displaySongs = Array();
                    foreach ($sortNewSongs as $key => $value) {
                      $song = Song::where('song_id', $value['song_id'])->first();
                      array_push($displaySongs, $song);
                    }

                    return $displaySongs;

            }
      }
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

  public function delplsong($sid, $pid)
  {
    $song = PList::where([
    ['song_id', $sid],
    ['pl_id', $pid],
    ])->delete();
    return redirect('playlist/'.$pid);
  }  

  public function recommendAlbums(){
      $user = Auth::user();

      // get all songs nga g paminaw sa user and group same song genre 
      $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

      $prefBands = Preference::where([
      ['user_id' , $user->user_id],
      ['band_id', '!=', 'null'],
      ])->get();

      $prefAlbums = Preference::where([
      ['user_id' , $user->user_id],
      ['album_id', '!=', 'null'],
      ])->get();

      // check if user naay preference
      if($getSongPlays != null) {

          $getSongs = Array();

          foreach($getSongPlays as $getSongPlay){
            $getGenre = $getSongPlay->songs->genre_id;
            $array = array('song_id' => $getSongPlay->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlay->category);
            array_push($getSongs, $array);
          }

          $collectSongs = collect($getSongs);
          $groupedSongsbyGenre = $collectSongs->groupBy('genre_id');

          // add corresponding score to each genre
          $genreScores = Array();

          foreach ($groupedSongsbyGenre as $key => $value) {
            $sumForCertainGenre = $value->sum('category');
            $scoreForCertainGenre = $sumForCertainGenre / count($value);
            $arrayScore = array('genre_id' => $key, 'score' => $scoreForCertainGenre);
            array_push($genreScores, $arrayScore);
          }
      
          $bands = Band::all();
          $notPrefBands = Array();
          $getGenresofNotPrefBands = Array();

          foreach($bands as $band){
            if(!$prefBands->contains('band_id', $band->band_id)){
              array_push($notPrefBands, $band);
              // get genres of not preferred bands
              $bandgenres = $band->bandgenres;
              foreach($bandgenres as $bandgenre){
                array_push($getGenresofNotPrefBands, $bandgenre);
              }
            }
          }

          $storeBandsBasedOnSameGenres = Array();
          // get bands with same genre
          foreach ($genreScores as $genreScore) {
            foreach ($getGenresofNotPrefBands as $getGenre) {
              if($genreScore['genre_id'] == $getGenre->genre_id){
                array_push($storeBandsBasedOnSameGenres, $getGenre->band);
              }
            }
          }

          if ($storeBandsBasedOnSameGenres != null){
            // get albums of bands
            // sort by album likes
            $albums = Array();
            foreach ($storeBandsBasedOnSameGenres as $band) {
              $getAlbums = $band->albums;
              foreach ($getAlbums as $getAlbum) {
                if(!$prefAlbums->contains('album_id', $getAlbum->album_id)){
                   array_push($albums, $getAlbum);
                }
              }
            }
            $collectAlbums = collect($albums);
            $sortAlbums = $collectAlbums->sortByDesc('num_likes')->take('5');

            return $sortAlbums;

          } else {
            // get not followed bands
            // get albums of bands
            // remove albums already liked
            // sort by album likes
            $bands = Band::all();
            $albums = Array();

              foreach($bands as $band){
                if(!$prefBands->contains('band_id', $band->band_id)){
                  $getAlbums = $band->albums;
                  foreach ($getAlbums as $getAlbum) {
                    if(!$prefAlbums->contains('album_id', $getAlbum->album_id)){
                       array_push($albums, $getAlbum);
                    }
                  }
                }
              }

            $collectAlbums = collect($albums);
            $sortAlbums = $collectAlbums->sortByDesc('num_likes')->take('5');

            return $sortAlbums;
          }


    } else {
            // get not followed bands
            // get albums of bands
            // remove albums already liked
            // sort by album likes
            $bands = Band::all();
            $albums = Array();

              foreach($bands as $band){
                if(!$prefBands->contains('band_id', $band->band_id)){
                  $getAlbums = $band->albums;
                  foreach ($getAlbums as $getAlbum) {
                    if(!$prefAlbums->contains('album_id', $getAlbum->album_id)){
                       array_push($albums, $getAlbum);
                    }
                  }
                }
              }

            $collectAlbums = collect($albums);
            $sortAlbums = $collectAlbums->sortByDesc('num_likes')->take('5');

            return $sortAlbums;
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