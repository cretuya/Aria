<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Album;
use App\Album_Contents;
use App\Article;
use App\Band;
use App\BandArticle;
use App\Bandmember;
use App\BandVideo;
use App\Genre;
use App\Song;
use App\User;
use \Session;
use Auth;	
use Laravel\Socialite\Facades\Socialite;

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

		return view('dashboard-band' , compact('band','videos', 'albums', 'articles', 'genres', 'songs', 'bandmembers','BandDetails'));
	}
	public function createBand(Request $request)
	{
		$name = $request->input('band_name');
		$role = $request->input('band_role_create');


		$create = Band::create([
			'band_name' => $name,
		]);


		$bandmember = Bandmember::create([
			'band_id' => $create->id,
			'user_id' => session('userSocial')['id'],
			'bandrole' => $role
			// 'band_desc' => $desc,
		]);

		return redirect('/'.$create->band_name.'/manage');
	}

	public function followBand($bname)
	{
		$band = Band::where('band_name', $bname)->first();

	}

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

    public function editBand(Request $request)
    {

    	// dd($request);

    	Band::where('band_id', $request->bandId)->update([
                "band_name" => $request->bandName,
                "band_desc" => $request->bandDesc
                ]);
    	$band_Name = $request->bandName;
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

}
