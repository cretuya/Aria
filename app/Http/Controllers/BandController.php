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
use App\Song;
use App\User;
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
        $genres = Genre::all();

        $songs = array();
        foreach ($albums as $album)
        {
            array_push($songs, Song::where('album_id', $album->album_id)->get());
        }

        $bandmembers = Bandmember::where('band_id',$band->band_id)->get();
        $BandDetails = Band::where('band_id', $band->band_id)->first();

        $bandGenreSelected = BandGenre::where('band_id', $band->band_id)->get();
        // dd($bandGenreSelected);


        return view('dashboard-band' , compact('band','videos', 'albums', 'articles', 'genres', 'songs', 'bandmembers','BandDetails','bandGenreSelected'));
    }
    public function createBand(Request $request)
    {
        $name = $request->input('band_name');
        $role = $request->input('band_role_create');
        // $role = $request->input('band_pic');


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
            ]);


            $bandmember = Bandmember::create([
                'band_id' => $create->id,
                'user_id' => session('userSocial')['id'],
                'bandrole' => $role
                // 'band_desc' => $desc,
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

    public function show($name)
    {
        $band = Band::where('band_name', $name)->first();
        $genres = $band->bandgenres;
        $articles = $band->bandarticles;

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
            return view('band-profile', compact('band', 'genres', 'articles', 'follower', 'followers'));
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

    public function visitCount(Request $request)
    {
        $band = Band::where('band_id', $request->input('id'))->first();
        $visitcount = $band->visit_counts;
        $newcount = $visitcount + 1;

        $update = Band::where('band_id', $band->band_id)->update([
            'visit_counts' => $newcount
        ]);

        return response ()->json($band);
    }
}
