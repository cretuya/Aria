<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bandmember;
use App\User;
use App\UserNotification;
use \Session;
use Laravel\Socialite\Facades\Socialite;

class BandMemberController extends Controller
{

	public function index($name)
	{

		$bandMember = Bandmember::where('user_id' ,$name)->first();
		// dd(Session::get('userSocial'));
		// dd($band);
		// return view('dashboard-band' , compact('bandMember'));
		return response ()->json($bandMember);
	}
	public function addBandMember(Request $request)
	{	
		try {

			$findMembertoAdd = User::Where('user_id',$request->input('add-band-member-id'))->first();
		
			$bandmember = Bandmember::create([
				'band_id' => $request->input('add-band-member-band-id'),
				'user_id' => $findMembertoAdd->user_id,
				'bandrole' => $request->input('add-band-member-role')
			]);

			return $bandmember;
			
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}

	public function deleteBandMember(Request $request){
		$memberID=$request->input('band-member-id');
		$delMember = Bandmember::where('user_id',$memberID)->delete();
		// dd($delMember);
		$bandName=$request->input('bandName');

		// return redirect('/'.$bandName."/manage");
		return response ()->json($delMember);

	}

	public function members()
	{
		$members = BandMember::all();

		return response()->json($members);
	}

	public function bandmembers(Request $request)
	{
		$members = Bandmember::where('band_id', $request->input('band_id'))->get();

		return response() ->json($members);
	}

	public function inviteUser(Request $request){

		$bandId = $request->input('band_id');
		$userId = $request->input('user_id');
		$bandRole = $request->input('band_role');
		$invitorId = $request->input('invitor_id');

		try{
			$invitation = UserNotification::create([
				'band_id' => $bandId,
				'user_id' => $userId,
				'bandrole' => $bandRole,
				'invitor' => $invitorId
			]);
			return "true";
		}
		catch(\Exception $e){
			return $e->getMessage();
		}
		
	}

	public function getUserNotification(Request $request){

		$notifs = UserNotification::where('user_id', $request->input('user_id'))->get();

		return response()->json($notifs);
	}

	public function declineInvitation(Request $request){

		$bandId = $request->input('band_id');
		$userId = $request->input('user_id');
		$bandRole = $request->input('bandrole');
		$invitorId = $request->input('invitor');

		try {

			$decline = UserNotification::where([
				'band_id' => $bandId,
				'user_id' => $userId,
				'bandrole' => $bandRole,
				'invitor' => $invitorId
			])->delete();

			return "true";
			
		} catch (\Exception $e) {
			return $e->getMessage();
		}
	}



}
