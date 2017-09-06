<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Bandmember;
use App\User;
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
		// dd($request->input('add-band-member-band-id'));
		$findMembertoAdd = User::Where('user_id',$request->input('add-band-member-id'))->first();
		// dd($findMembertoAdd);
		$bandmember = Bandmember::create([
				'band_id' => $request->input('add-band-member-band-id'),
				'user_id' => $findMembertoAdd->user_id,
				'bandrole' => $request->input('add-band-member-role')
				// 'band_desc' => $desc,
			]);

		$bandName=$request->input('add-band-member-band-name');
		

		// return redirect('/'.$bandName."/manage");
		return response ()->json($findMembertoAdd,$bandmember);
	}

	public function deleteBandMember(Request $request){
		$memberID=$request->input('band-member-id');
		$delMember = Bandmember::where('user_id',$memberID)->delete();
		// dd($delMember);
		$bandName=$request->input('bandName');

		// return redirect('/'.$bandName."/manage");
		return response ()->json($delMember);

	}




}
