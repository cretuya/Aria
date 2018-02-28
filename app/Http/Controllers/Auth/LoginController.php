<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use \Session;
use \DateTime;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
        {
            return Socialite::driver('facebook')->fields([
                        'first_name', 'last_name', 'email', 'gender', 'birthday', 'friends'
                    ])->scopes([
                        'email', 'user_birthday', 'user_friends'
                    ])->redirect();
        }

        /**
         * Obtain the user information from facebook.
         *
         * @return Response
         */
        public function handleProviderCallback(Request $request)
        {

            if (!$request->has('code') || $request->has('denied')) {
                return redirect('/');
            }

            // $userSocial = Socialite::driver('facebook')->user();
            $userSocial = Socialite::driver('facebook')->fields([
                        'first_name', 'last_name', 'email', 'gender', 'birthday', 'friends'
                    ])->user();

            Session::put('userSocial',$userSocial->user);
            Session::put('userSocial_City', '');
            Session::put('userSocial_Contact', '');
            Session::put('userSocial_Bio', '');
            Session::put('userSocial_avatar', $userSocial->avatar_original);
            // dd($userSocial);

            // $bandsOfFbUser = DB::table('bands')->join('bandmembers', 'band.id', '=', 'bandmembers.band')->selectRaw('bands.band_name')->get();

            // dd($bandsOfFbUser);

            // dd(Session::get('user'));
            // dd($user->token);
            // dd($userSocial);
            // return view('user-profile', compact('user',$user));

            // $parts = explode(" ", $userSocial->name);
            // $lastname = array_pop($parts);
            // $firstname = implode(" ", $parts);

            // dd($userSocial->user['first_name'],$userSocial->user['last_name'],$userSocial->user['email'],$userSocial->user['gender'],$userSocial->user['birthday']);



            // $date = new DateTime($userSocial->user['birthday']);
            // $now = new DateTime();
            // $interval = $now->diff($date);

            // dd($interval->y); // age

            $findUser = User::Where('email',$userSocial->email)->first();

            if ($findUser) {
                Auth::login($findUser);
                return redirect('/home');
            }
            else
            {
                $user = new User();
                // $user->fname = $firstname;
                // $user->lname = $lastname;
                $user->user_id = $userSocial->user['id'];
                $user->fname = $userSocial->user['first_name'];
                $user->lname = $userSocial->user['last_name'];
                $user->fullname = $userSocial->user['first_name']." ".$userSocial->user['last_name'];
                $user->email = $userSocial->user['email'];
                $user->age = null;
                // $user->age = $interval->y;
                $user->gender = $userSocial->user['gender'];
                $user->address = '';
                $user->contact = '';
                $user->profile_pic = $userSocial->avatar_original;
                $user->save();

                
                Auth::login($user);

                // return 'done';
                $_SESSION= '';
                return redirect('/home');
            }

        }

}
