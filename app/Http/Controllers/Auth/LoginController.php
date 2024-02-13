<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Session;


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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /*
    //By default, Laravel uses the email field for authentication, change email to username
    public function username(){
        return 'username';
    }

    protected function credentials(Request $request){
        return $request->only($this->username(), 'password', 'active');
    }
    */


    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request), 6, 30
        );
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login')->with(['message'=>'Logout successfully!', 'alert-type'=>'success']);
    }


    function authenticated(Request $request, $user)
    {
        $user->update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);

        $data = $request->all();

        if(Auth::attempt([ 'email'=>$data['email'], 'password'=>$data['password'] ]))
        {
            //return redirect()->route('dashboard')->with(['message'=>'Login done successfully!', 'alert-type'=>'success']);
            return redirect()->intended($this->redirectPath()); //Redirect previous page after login.
        }

    }
}
