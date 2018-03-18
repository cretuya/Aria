<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Bandmember;
use App\Preference;
use App\UserHistory;
use App\Playlist;
use App\Plist;
use App\Band;
use App\Song;
use App\Album;
use App\Video;


class UserController extends Controller
{
    
	public function updateUser(Request $request)
        {
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["address" => "input['users-city']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["contact" => "input['users-contact']"]);
            // User::('users')->where('user_id', session('userSocial')['id'])->update(["email" => "input['users-email"]);

            $updateUserInfo = User::where('user_id', session('userSocial')['id'])
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

            // return redirect('/user/profile');
			return response ()->json($updateUserInfo);

        }

    public function show(){
           // $userRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->first();
           //  return view('user-profile', compact('userRole'));
        $user = User::where('user_id',session('userSocial')['id'])->first();

        $usersBand = Band::join('bandmembers', 'bands.band_id', '=', 'bandmembers.band_id')->select('band_name')->where('user_id', session('userSocial')['id'])->first();
        $userHasBand = Bandmember::where('user_id',session('userSocial')['id'])->get();
        $userBandRole = Bandmember::select('bandrole')->where('user_id',session('userSocial')['id'])->get();
        // dd($userBandRole);
            // return view('user-profile', compact('userHasBand','userBandRole'));
		return response ()->json($userHasBand,$userBandRole,$usersBand,$user);

    }

    public function saveUser(Request $request)
    {
        $user = $request->input('user_id');
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $fullname = $fname." ".$lname;
        $email = $request->input('email');
        $age = $request->input('age');
        $gender = $request->input('gender');
        $address = $request->input('address');
        $contact = $request->input('contact');
        $bio = $request->input('bio');
        $pic = $request->input('pic');

        $create = User::create([
            'user_id' => $user,
            'fname' => $fname,
            'lname' => $lname,
            'fullname' => $fullname,
            'email' => $email,
            'age' => $age,
            'gender' => $gender,
            'address' => $address,
            'contact' => $contact,
            'bio' => $bio,
            'profile_pic' => $pic,
        ]);

        return response()->json($create);
    }
    public function getusers()
    {
        $users = User::all();

        return response()->json($users);
    }

    public function preferences(Request $request)
    {
        $preferences = Preference::where('user_id', $request->input('user_id'))->get();

        return response() ->json($preferences); 
    }

    public function userhistory(Request $request)
    {
        $userhistory = UserHistory::where('user_id', $request->input('user_id'))->get();

        if (count($userhistory) > 0)
        {
           return response() ->json($userhistory);            
        }
        else
        {
            return response() ->json(['message' => 'No userhistory found in the table.']);   
        }
    }

    public function AddPlayList(Request $request){

      $uid = $request->input('user_id');
      $title = $request->input('pl_title');
      $image = $request->file('pl_image');

      \Cloudder::upload($image);
      $cloudder=\Cloudder::getResult();

      $create = Playlist::create([
            'pl_title' => $title,
            'pl_creator' => $uid,
            'image' => $cloudder['url'],
          ]);

      return response() ->json($create);;
    }

    public function DeletePlayList(Request $request){

        $id = $request->input('pl_id');

        $delete = Playlist::where('pl_id', $id)->delete();
    }

    public function updateplaylist(Request $request)
    {
        $id = Playlist::where('pl_id', $request->input('pl_id'))->first();
        $title = $request->input('pl_title');
        $desc = $request->input('pl_desc');
        $image = $request->file('pl_image');

        if($image != null){
          \Cloudder::upload($image);
          $cloudder=\Cloudder::getResult();

        
          $update = Playlist::where('pl_id', $id->pl_id)->update([
            'pl_title' => $title,
            'pl_desc' => $desc,
            'image' => $cloudder['url'],
          ]);
        }
        else{
            $update = Playlist::where('pl_id', $id->pl_id)->update([
            'pl_title' => $title,
            'pl_desc' => $desc,
          ]);
        }
    }

    public function getAllPlaylist(Request $request){
        $playlists = Playlist::all();

        return response() ->json($playlists);
    }

    public function addSongToPlaylist(Request $request){
        
        $genre = $request->input('genre_id');
        $song = $request->input('song_id');
        $playlistId = $request->input('pl_id');

        $create = Plist::create([
        'genre_id' => $genre,
        'song_id' => $song,
        'pl_id' => $playlistId,
      ]);
    }

    public function getAllPlist(Request $request){
        $plist = Plist::all();
        return response() ->json($plist);
    }

    public function removeSongFromPlaylist(Request $request) {
        $id = $request->input('pl_id');
        $song = $request->input('song_id');

        $delete = Plist::where([
            ['song_id',$song],
            ['pl_id',$id],
        ])->delete();
    }

    public function getPlistById(Request $request){
        $plist = Plist::where('pl_id', $request->input('pl_id'))->get();
        return response()->json($plist);
    }

    public function followPlaylist(Request $request){
        
        $userId = $request->input('user_id');
        $pid = $request->input('pid');

        $create = Preference::create([
            'user_id' => $userId,
            'pl_id' => $pid,
        ]);

        $followers = count(Preference::where('pl_id' ,$pid)->get());

        $playlist = Playlist::where('pl_id', $pid)->update([
            'followers' => $followers,
        ]);

        return response()->json($followers);
        
    }

    public function unFollowPlaylist(Request $request){

        $user = $request->input('user_id');
        $pid = $request->input('pid');

        $delete = Preference::where([
        ['user_id' , $user],
        ['pl_id', $pid],
        ])->delete();

        $followers = count(Preference::where('pl_id' ,$pid)->get());

        $playlist = Playlist::where('pl_id', $pid)->update([
        'followers' => $followers,
        ]);

        return response()->json($followers);

    }


    public function searchFunction(Request $request){
        $termSearched = $request->input('term');

        $userResult = User::where('fullname', 'LIKE', '%'.$termSearched.'%')->get();

        $bandResult = Band::where('band_name', 'LIKE', '%'.$termSearched.'%')->get();

        $playlistResult = Playlist::where('pl_title', 'LIKE', '%'.$termSearched.'%')->get();

        $songResult = Song::where('song_title', 'LIKE', '%'.$termSearched.'%')->get();

        $albumResult = Album::where('album_name', 'LIKE', '%'.$termSearched.'%')->get();

        $videoResult = Video::where('video_title', 'LIKE', '%'.$termSearched.'%')->get();

        return response()->json([
            'band' => $bandResult, 
            'user' => $userResult, 
            'playlist' => $playlistResult,
            'song' => $songResult,
            'album' => $albumResult,
            'video' => $videoResult]);
    }

    public function recommendBands(Request $request){
          $user = User::where('user_id', $request->input('user_id'));

          // get all songs nga g paminaw sa user and group same song genre 
          $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

          $prefBands = Preference::where([
          ['user_id' , $user->user_id],
          ['band_id', '!=', 'null'],
          ])->get();

          // scores for certain category
          $category1 = 10;
          $category2 = 6;
          $category3 = 2;
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
                  $countforcat1 = $value->where('category', 1);
                  $countforcat2 = $value->where('category', 2);
                  $countforcat3 = $value->where('category', 3);

                  $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));

                  $arrayScore = array('genre_id' => $key, 'score' => $getScoreforCats);
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

                return response()->json($rankBands);

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

                return response()->json($rankBands);
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

                return response()->json($rankBands);   
        }
    }


  public function recommendAlbums(Request $request){
          $user = User::where('user_id', $request->input('user_id'));

          // get all songs nga g paminaw sa user and group same song genre 
          $getSongPlays = SongsPlayed::where('user_id', $user->user_id)->get();

          // scores for certain category
          $category1 = 10;
          $category2 = 6;
          $category3 = 2;

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
                  $countforcat1 = $value->where('category', 1);
                  $countforcat2 = $value->where('category', 2);
                  $countforcat3 = $value->where('category', 3);

                  $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
                  
                  $arrayScore = array('genre_id' => $key, 'score' => $getScoreforCats);
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

                return response()-> json($sortAlbums);

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

                return response()-> json($sortAlbums);
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

                return response()-> json($sortAlbums);
                
           }
  }


  public function recommendplaylist(Request $request){
      $user = User::where('user_id', $request->input('user_id'));

      // scores for certain category
      $category1 = 10;
      $category2 = 6;
      $category3 = 2;

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
              $countforcat1 = $value->where('category', 1);
              $countforcat2 = $value->where('category', 2);
              $countforcat3 = $value->where('category', 3);

              $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));

              $arrayScore = array('genre_id' => $key, 'score' => $getScoreforCats);
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
                $countforcat1 = $value->where('category', 1);
                $countforcat2 = $value->where('category', 2);
                $countforcat3 = $value->where('category', 3);

                $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));

                $arrayScore = array('genre_id' => $key, 'score' => $getScoreforCats);
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

          return response()-> json($filteredSongs);

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
                  
                return response()-> json($displaySongs);
                

          } else {
                $user = User::where('user_id', $request->input('user_id'));

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
                        $countforcat1 = $value->where('category', 1);
                        $countforcat2 = $value->where('category', 2);
                        $countforcat3 = $value->where('category', 3);

                        $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));

                        $arrayScore = array('genre_id' => $key, 'score' => $getScoreforCats);
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

                return response()-> json($displaySongs);

            }
      }
  }


    public function recommendplaylists(Request $request)
    {
        $user = User::where('user_id', $request->input('user_id'));
        $preferences = Preference::where('user_id', $user->user_id)->get();

        $getBandPreferences = Array();
        $getAlbumPreferences = Array();

        foreach($preferences as $preference){
            if($preference->band_id != null)
            {
                array_push($getBandPreferences, $preference);
            }
        }
        foreach($preferences as $preference){
            if($preference->album_id != null){
                array_push($getAlbumPreferences, $preference);
            }
        }

        $genres = Array();
        if(count($getBandPreferences) > 0 ){
            foreach($getBandPreferences as $getBand)
            {
                $band = Band::where('band_id', $getBand->band_id)->first();
                $bandGenres = $band->bandgenres;
                foreach($bandGenres as $bandGenre)
                {
                    array_push($genres, $bandGenre->genre_id);
                }

            }
            $unique = array_unique($genres);
            $sorted = Array();

            foreach($unique as $un){
                $songs = Song::where('genre_id', $un)->get();
                if(count($songs) != null){
                    $genre = Genre::where('genre_id', $un)->first();
                    array_push($sorted, $genre);
                }
            }
            return response()-> json($sorted);
        }
        else if (count($getAlbumPreferences) > 0) {
            foreach($getAlbumPreferences as $getAlbum)
            {
                $band = $getAlbum->album->band;
                $bandGenres = $band->bandgenres;
                foreach($bandGenres as $bandGenre)
                {
                    array_push($genres, $bandGenre->genre_id);
                }

            }
            $unique = array_unique($genres);
            $sorted = Array();

            foreach($unique as $un){
                $songs = Song::where('genre_id', $un)->get();
                if(count($songs) != null){
                    $genre = Genre::where('genre_id', $un)->first();
                    array_push($sorted, $genre);
                }
            }
            return response()-> json($sorted);
        }
        else {

            $genres = Genre::all();
            $sorted = Array();

            foreach ($genres as $genre)
            {
                $songs = Song::where('genre_id', $genre->genre_id)->get();
                if (count($songs) != null)
                {
                    array_push($sorted, $genre);
                }
            } 
            return response()-> json($sorted);
                      
        }

    }

    public function showSongsGenre($id)
    {
        $genre = Genre::where('genre_id', $id)->first();
        // $songs = Song::where('genre_id', $id)->get();
        $songs = Array();

        $getSongsPlayed = SongsPlayed::all();
        $getSongs = Array();

          foreach($getSongsPlayed as $getSongPlayed){
            $getGenre = $getSongPlayed->songs->genre_id;
            $array = array('song_id' => $getSongPlayed->song_id, 'genre_id' => $getGenre, 'category' => $getSongPlayed->category);
            if ($getGenre == $genre->genre_id){
                array_push($getSongs, $array);
            }
          }

          if ($getSongs != null) {
              $collectSongs = collect($getSongs);
              $groupedSongsbyId = $collectSongs->groupBy('song_id');
              $storeSongwithScore = Array();

              $category1 = 10;
              $category2 = 6;
              $category3 = 2;
            // calculate the scores
            $scoreBasedOnCategory = Array();
            foreach ($groupedSongsbyId as $key => $value) {
                  $countforcat1 = $value->where('category', 1);
                  $countforcat2 = $value->where('category', 2);
                  $countforcat3 = $value->where('category', 3);

                  $getScoreforCats = ($category1 * count($countforcat1)) + ($category2 * count($countforcat2)) + ($category3 * count($countforcat3));
                  $array = array('song_id' => $key, 'scoreforsong' => $getScoreforCats);
                  array_push($scoreBasedOnCategory, $array);

            }

            // sort songs
            $collectSongs = collect($scoreBasedOnCategory);
            $sortBySongs = $collectSongs->sortByDesc('scoreforsong');
            $songs = Array();
              foreach ($sortBySongs as $key => $value) {
                $song = Song::where('song_id', $value['song_id'])->first();
                array_push($songs, $song);
              }

          } else {
                $getSongs = Song::where('genre_id', $id)->get();
                $getBandsofSong = Array();

                foreach ($getSongs as $song) {
                    $bandscore = $song->album->band->band_score;
                    $array = array('song_id' => $song->song_id, 'band_score' => $bandscore);
                    array_push($getBandsofSong, $array);
                }
                $collectBandsOfSong = collect($getBandsofSong);
                $sortSongs = $collectBandsOfSong->sortByDesc('band_score'); 
                $songs = Array();
                foreach ($sortSongs as $sortSong) {
                    $song = Song::where('song_id', $sortSong['song_id'])->first();
                    array_push($songs, $song);
                }

          }

          
        return response()->json($songs);

    }






}
