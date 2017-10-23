<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Band;
use App\Bandmember;
use App\BandGenre;
use App\BandArticle;
use App\Preference;
Use App\Song;

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

        // dd($articlesfeed);
        $recommend = $this->recommend();
        dd($recommend);
        return view('feed', compact('userHasBand','userBandRole','usersBand','user', 'friends','articlesfeed', 'recommend'));
    }

    public function recommend()
    {
        $user = User::where('user_id',session('userSocial')['id'])->first();
        $preferences = Preference::where('user_id', $user->user_id)->get();
        $temp = Array();
        $get = Array();
        $bands = Band::all();
        $genreArray= Array();

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
            foreach($get as $g)
            {
              $genres = $g->bandgenres;
              foreach ($preferences as $preference)
              {
                $pgenres = $preference->band->bandgenres;
                foreach ($genres as $genre){
                  // if (in_array($genre->genre_id,))
                  // {
                  //   array_push($genreArray, $genres);
                  // }
                }
              }
              // $genre = collect($g->bandgenres);
              // foreach ($preferences as $preference)
              // {
              //   $pgenre = collect($preference->band->bandgenres)->all();
              //   $diff = array_diff($genre, $pgenre);
                // $count = count($diff);
            }
            return $pgenres->genre->genre_id;

        }
        else
        {
          $randomBands = Band::inRandomOrder()->get();
          $randomSongs = Song::inRandomOrder()->get();
          return array($randomBands, $randomSongs);
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

        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();

        // dd($bandsfollowed);
        // dd($usersBand);
        //nag usab ko diri
            return view('user-profile', compact('userHasBand','userBandRole','usersBand','user','bandsfollowed','bandsfollowedNoGenre'));
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
        // dd($bandsfollowed);
        // $bandGenre = BandGenre::select('genre_name')->join('genres', 'bandgenres.genre_id', '=', 'genres.genre_id')->join('bands', 'bandgenres.band_id', '=', 'bands.band_id')->get();
        //nag usab ko diri
        return view('friend-profile', compact('user', 'userHasBand','userBandRole','usersBand','bandsfollowed','bandsfollowedNoGenre'));
    }

}
