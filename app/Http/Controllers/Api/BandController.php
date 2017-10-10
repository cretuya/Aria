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
use App\Genre;
use App\Song;
use App\User;
use App\Preference;
use \Session;
use Auth;	
use Laravel\Socialite\Facades\Socialite;

class BandController extends Controller
{
	public function createBand(Request $request)
	{
		$name = $request->input('band_name');
		$role = $request->input('band_role_create');
		$uid = $request->input('user_id');
		$user = User::where('user_id', $uid)->first();

		if(count($user) > 0)
		{
			$create = Band::create([
				'band_name' => $name,
				'band_pic' => 'dummy-pic.jpg'
			]);

			$bandmember = Bandmember::create([
				'band_id' => $create->id,
				'user_id' => $uid,
				'bandrole' => $role,
				// 'band_desc' => $desc,
			]);	
			return response ()->json(['band' => $create ,'member' => $bandmember]);		
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
        return response ()->json(['band' => $newband, 'preference' => $create]);

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

        return response ()->json(['band' => $newband, 'preference' => $follower]);
    }
    public function visitCount(Request $request)
    {
        $band = Band::where('band_id', $request->input('band_id'))->first();
        $visitcount = $band->visit_counts;
        $newcount = $visitcount + 1;

        $update = Band::where('band_id', $band->band_id)->update([
            'visit_counts' => $newcount
        ]);

        return response ()->json($band);
    }
    public function bands()
    {
        $bands = Band::all();

        return response() ->json($bands);
    }
}
