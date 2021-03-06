<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Band;
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
		return view('dashboard-band' , compact('bandMember'));
	}
	public function addBandMember(Request $request)
	{	
		// dd($request->input('add-band-member-band-id'));
		$findMembertoAdd = User::Where('user_id',$request->input('add-band-member-id'))->first();
		// dd($findMembertoAdd);

		$usertobeaddednotification = UserNotification::where('user_id',$findMembertoAdd->user_id)->where('band_id',$request->input('add-band-member-band-id'))->get();
		// dd($usertobeaddednotification);

		$invitor = session('userSocial')['first_name']." ".session('userSocial')['last_name'];
		if ( count($usertobeaddednotification) == 0 ){
			$sendRequest = UserNotification::create([
				'user_id' => $findMembertoAdd->user_id,
				'band_id' => $request->input('add-band-member-band-id'),
				'bandrole' => $request->input('add-band-member-role'),
				'invitor' => $invitor
			]);

			$bandName=$request->input('add-band-member-band-name');
			echo "<script type='text/javascript'>alert('An invite has been sent to ".$findMembertoAdd->fullname."');</script>";
			echo "<script type='text/javascript'>window.location.href='".$bandName."/manage';</script>";
		}
		else{
			$bandName=$request->input('add-band-member-band-name');
			echo "<script type='text/javascript'>alert('An invite has already been sent to ".$findMembertoAdd->fullname."');</script>";
			echo "<script type='text/javascript'>window.location.href='".$bandName."/manage';</script>";

		}
		


//--------------------------------------------------------------------------
		// $bandmember = Bandmember::create([
		// 		'band_id' => $request->input('add-band-member-band-id'),
		// 		'user_id' => $findMembertoAdd->user_id,
		// 		'bandrole' => $request->input('add-band-member-role')
		// 		// 'band_desc' => $desc,
		// 	]);
//--------------------------------------------------------------------------

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

		// return redirect('/'.$bandName."/manage");
	}

	public function acceptRequest(Request $request){
		$bandName = $request->input('band_name_requested1');
		$bandID = $request->input('band_id_requested1');
		$userID = $request->input('user_id_requested1');
		$bandrole = $request->input('bandrole_requested1');
		$invitor = $request->input('invitor_requested1');

		$bandmember = Bandmember::create([
			'band_id' => $bandID,
			'user_id' => $userID,
			'bandrole' => $bandrole
		 	]);

		$delInvite = UserNotification::where([
			['band_id', $bandID],
			['user_id', $userID],			
			['bandrole', $bandrole],
			['invitor', $invitor],
		])->delete();
		
		return redirect('/'.$bandName."/manage");
	}

	public function ignoreRequest(Request $request){
		$url = $request->input('urlbeforeignore');
		$newUrl = substr($url ,-(strlen($url)-1));

		$bandID = $request->input('band_id_requested2');
		$userID = $request->input('user_id_requested2');
		$bandrole = $request->input('bandrole_requested2');
		$invitor = $request->input('invitor_requested2');

		$delInvite = UserNotification::where([
			['band_id', $bandID],
			['user_id', $userID],			
			['bandrole', $bandrole],
			['invitor', $invitor],
		])->delete();

		return redirect('../../'.$newUrl);

	}

	public function editrolemember(Request $request){
		$bandName=$request->input('band_name');
		$bandmemberID = $request->input('member_id');
		// dd($bandmemberID);
		$bandmemberrole = $request->input('member_role');
		$bandidofmember = $request->input('band_id');

		$updaterole = Bandmember::where([
					['user_id', $bandmemberID],
					['band_id', $bandidofmember],			
				])->update([
					'bandrole' => $bandmemberrole
			 	]);

		return redirect('/'.$bandName."/manage");
	}

	public function deleteBandMember(Request $request){
		$memberID=$request->input('band-member-id');

		$delMember = Bandmember::where([
			['user_id', $memberID],
			['band_id', $request->input('band-id')],
		])->delete();

		$numOfBandMembers = Bandmember::where('band_id', $request->input('band-id'))->get();

		if (count($numOfBandMembers)==0) {
			$delBand = Band::where('band_id', $request->input('band-id'))->delete();
			return redirect('/home');
		}		

		// dd($delMember);
		$bandName=$request->input('bandName');

		return redirect('/'.$bandName."/manage");

	}




}
