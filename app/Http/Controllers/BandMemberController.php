<?php

namespace App\Http\Controllers;

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
		return view('dashboard-band' , compact('bandMember'));
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

		// $CurrentUserIsBandMember = Bandmember::Where('user_id',session('userSocial')['id'])->first();

		// if ($CurrentUserIsBandMember) {
		// 	$memberName = $request->input('add-band-member');
		// 	$role = $request->input('add-band-member-role');
			
		// 	$bandmember = Bandmember::create([
		// 		'band_id' => $create->band_id,
		// 		'user_id' => $findMembertoAdd,
		// 		'role' => $role
		// 		// 'band_desc' => $desc,
		// 	]);
		// }
		// else
		// {

		// 	$memberName = $request->input( {{session('userSocial')['id']}} );
		// 	$role = $request->input('band_role_create');
		// 	// $desc = $request->input('band_desc');

		// 	$bandmember = Bandmember::create([
		// 		'band_id' => $create->band_id,
		// 		'user_id' => session('userSocial')['id'],
		// 		'role' => $role
		// 		// 'band_desc' => $desc,
		// 	]);

		// }

		$bandName=$request->input('add-band-member-band-name');
		

		return redirect('/'.$bandName."/manage");
	}

	public function deleteBandMember(Request $request){
		$memberID=$request->input('band-member-id');
		$delMember = Bandmember::where('user_id',$memberID)->first();
		// dd($delMember);
		$delMember->destroy();
	}




}
