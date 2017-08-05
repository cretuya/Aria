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

		$findMembertoAdd = User::Where('fullname',$request->input('add-band-member'))->select('user_id')->first();

		$CurrentUserIsBandMember = Bandmember::Where('user_id',session('userSocial')['id'])->first();

		if ($CurrentUserIsBandMember) {
			$memberName = $request->input('add-band-member');
			$role = $request->input('add-band-member-role');
			
			$bandmember = Bandmember::create([
				'band_id' => $create->band_id,
				'user_id' => $findMembertoAdd,
				'role' => $role
				// 'band_desc' => $desc,
			]);
		}
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


		

		return redirect('/'.$create->band_name);
	}




}
