<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Bandmember;

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
    public function users()
    {
        $users = User::all();

        return response()->json($users);
    }

}
