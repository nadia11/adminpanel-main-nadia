<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Hash;


class ApiWebRiderController extends Controller
{
    public function registration_form() {
        $manage_member = view('pages.web-rider.registration-form');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function rider_registration_form_save( Request $request)
    {
        $max_id = DB::table('riders')->max('rider_id'); $rd_max_id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0". ($max_id + 1) : $max_id + 1);
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            //'date_of_birth' => 'date_format:d/m/Y',
            'mobile' => 'required|numeric|unique:riders',
            'email' => 'required|unique:riders'
        ],
        [
            'mobile.unique' => 'The Mobile already taken. Please change or login',
            'email.unique' => 'The Email already taken.'
        ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
            //return array( 'fail' => true, 'errors' => $validator->getMessageBag()->toArray() );
        }

        $user_data = array(
            'name'       => $request->rider_name,
            'mobile'     => $request->mobile,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'role_id'    => 6, /***Rider role**/
            'status'     => "active",
            'created_at' => date('Y-m-d H:i:s'),
        );
        if ($request->hasFile('rider_photo')) {
            $upload_dir = storage_path('uploads/user-photo');
            $files = $request->file('rider_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $rider_photo = "rd_photo_".$rd_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".".$extension;
            $success = $files->move( $upload_dir, $rider_photo );

            $user_data['user_photo'] = $rider_photo;
        }
        $user_id = DB::table('users')->insertGetId( $user_data );


        $data = array(
            'user_id'         => $user_id,
            'rider_name'      => $request->rider_name,
            'mobile'          => $request->mobile,
            'email'           => $request->email,
            'rider_status'    => "active",
            'referral_name'   => $request->referral_name,
            'referral_mobile' => $request->referral_mobile,
            'reg_date'        => date('Y-m-d H:i:s'),
            'created_at'      => date('Y-m-d H:i:s'),
        );

        $user_photo_dir = upload_path('/user-photo');
        $user_photo = $user_data['user_photo'];

        if (file_exists($user_photo_dir."/".$user_photo)) {
            Storage::disk('uploads')->copy("/user-photo/".$user_photo, "/rider-photo/".$user_photo);
            $data['rider_photo'] = $user_photo;
        }
        DB::table('riders')->insert( $data );

        return Redirect::to('web/rider/registration-success')->with('success', 'Created New Account Successfully!');
    }

    public function registration_success() {
        $manage_member = view('pages.web-rider.registration-success');
        return view('web_api')->with('main_content', $manage_member);
    }


    public function login_form() {
        $this->auth_check();
        $manage_member = view('pages.web-rider.login');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function rider_login_check(Request $request){
        if(DB::table('users')->where('email', $request->email)->doesntExist()){
            return Redirect::to('web/rider/login-form')->with(['error'=>'Invalid Username or Password. Please try again'])->send();
        }

        $users = DB::table('users')->where('email', $request->email)->first();

        if (Hash::check( $request->password, $users->password)) {
            Session::put('user_id', $users->id);
            Session::put('user_name', ucwords( $users->name) );
            Session::put('user_email', $users->email);
            Session::put('user_mobile', $users->mobile);
            Session::forget('error');
            return Redirect::to('web/rider/profile')->send();
        }else{
            Session::put('error', 'The password that you have entered is incorrect.');
            return Redirect::to('web/rider/login-form')->send();
        }
    }

    public static function login_auth_check(){
        $user_id = Session::get('user_id');
        if( $user_id == NULL ){
            return Redirect::to('web/rider/login-form')->send();
        }
    }

    public static function auth_check(){
        $user_id = Session::get('user_id');
        if( $user_id !== NULL ){
            return Redirect::to('/web/rider/profile')->send();
        }
    }

    public function logout(){
        Session::put('user_name', null);
        Session::put('user_id', null);

        return redirect('web/rider/login-form')->with('success', 'You are successfully logout!');
        //Session::put('success', 'You are successfully logout!');
        //return Redirect::to('/admin-login')->send();
    }

    public function profile(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'profile-content');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function my_wallet(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'my-wallet');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function trip_history(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'trip-history');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function scheduled_trips(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'scheduled-trips');
        return view('web_api')->with('main_content', $manage_member);
    }


    public function edit_profile() {
        self::login_auth_check();
        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'edit-profile');

        return view('web_api')->with('main_content', $manage_member);
    }

    public function change_password() {
        self::login_auth_check();
        $manage_member = view('pages.web-rider.profile')->with('profile_content', 'change-password');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function change_password_save(Request $request) {
        $check_old_password = DB::table('users')->where('id', Session::get('user_id'))->value('password');

        if (Hash::check( $request->old_password, $check_old_password)) {
            $user_data = array(
                'password'   => Hash::make( $request->password ),
                'updated_at' => date('Y-m-d H:i:s')
            );

            DB::table('users')->where('id', Session::get('user_id'))->update( $user_data );

            return redirect('profile')->with('message', 'Password Updated Successfully!');
        } else {
            Session::put('error', 'Old Password is incorrect. Please try again!');
            return back()->withErrors('Old Password is incorrect. Please try again!')->withInput();
        }
    }
}
