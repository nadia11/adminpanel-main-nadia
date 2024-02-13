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


class ApiWebDriverController extends Controller
{
    public function registration_form() {
        $manage_member = view('pages.web-driver.registration-form');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function driver_registration_form_save( Request $request)
    {
        $max_id = DB::table('drivers')->max('driver_id'); $dr_max_id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0". ($max_id + 1) : $max_id + 1);
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
            'name'       => $request->driver_name,
            'email'      => $request->email,
            'mobile'     => $request->mobile,
            'password'   => bcrypt($request->password),
            'role_id'    => 5, /***Driver role**/
            'status'     => "pending",
            'created_at' => date('Y-m-d H:i:s'),
        );
        if ($request->hasFile('driver_photo')) {
            $upload_dir = upload_path('/user-photo' );
            $files = $request->file('driver_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "dr_photo_".$dr_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".".$extension;

            if (file_exists($upload_dir."/".$file_name)) { unlink($upload_dir."/".$file_name); }
            $success = $files->move( $upload_dir, $file_name );

            $user_data['user_photo'] = $file_name;
        }
        $user_id = DB::table('users')->insertGetId( $user_data );


        $data = array(
            'user_id'         => $user_id,
            'driver_name'     => $request->driver_name,
            'mobile'          => $request->mobile,
            'email'           => $request->email,
            'country_name'    => "Bangladesh",
            'division_id'     => $request->division_id,
            'district_id'     => $request->district_id,
            'branch_id'       => $request->branch_name,
            'national_id'     => $request->national_id,
            'driver_status'   => "pending",
            'profile_status'  => "complete",
            'approval_status' => "unapproved",
            'driving_licence' => $request->driving_licence,
            'referral_name'   => $request->referral_name,
            'referral_mobile' => $request->referral_mobile,
            'reg_date'        => date('Y-m-d H:i:s'),
            'created_at'      => date('Y-m-d H:i:s'),
        );

        $user_photo_dir = upload_path('/user-photo');
        $user_photo = $user_data['user_photo'];

        if (file_exists($user_photo_dir."/".$user_photo)) {
            Storage::disk('uploads')->copy("/user-photo/".$user_photo, "/driver-photo/".$user_photo);
            $data['driver_photo'] = $user_photo;
        }
        $driver_id = DB::table('drivers')->insertGetId( $data );

        $vehicle_data = array(
            'driver_id'              => $driver_id,
            'vehicle_type_id'        => $request->vehicle_type_id,
            'vehicle_model'          => $request->vehicle_model,
            'vehicle_reg_number'     => $request->vehicle_reg_number,
            'vehicle_tax_token'      => $request->vehicle_tax_token,
            'tax_renewal_date'       => $request->tax_renewal_date ? Carbon::createFromFormat('d/m/Y', $request->tax_renewal_date )->format('Y-m-d') : null,
            'insurance_number'       => $request->insurance_number,
            'insurance_renewal_date' => $request->insurance_renewal_date ? Carbon::createFromFormat('d/m/Y', $request->insurance_renewal_date )->format('Y-m-d') : null,
            //'seat_capacity'          => $request->seat_capacity,
            'fitness_certificate'    => $request->fitness_certificate,
            'created_at'             => date('Y-m-d H:i:s'),
        );
        //if ($request->hasFile('vehicle_photo')) {
        //    $upload_dir = upload_path('/vehicle-photo' );
        //    $files = $request->file('vehicle_photo');
        //
        //    $file_name_WithExt = $files->getClientOriginalName();
        //    $extension = strtolower( $files->getClientOriginalExtension() );
        //    $vehicle_photo = "dr_".$dr_max_id."_".$request->vehicle_reg_number . Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".".$extension;
        //    $success = $files->move( $upload_dir, $vehicle_photo );
        //
        //    $vehicle_data['vehicle_photo'] = $vehicle_photo;
        //}
        DB::table('vehicles')->insert( $vehicle_data );

        return Redirect::to('web/driver/registration-success')->with('success', 'Created New Account Successfully!');
    }

    public function registration_success() {
        $manage_member = view('pages.web-driver.registration-success');
        return view('web_api')->with('main_content', $manage_member);
    }


    public function login_form() {
        $this->auth_check();
        $manage_member = view('pages.web-driver.login');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function driver_login_check(Request $request){
        //echo strlen($request->password);
        //dd($request->all());
        if(DB::table('users')->where('email', $request->email)->doesntExist()){
            //return response()->json(['error'=>"Invalid Username or Password. Please try again."]);
            Session::put('error', 'Invalid Username or Password. Please try again.');
            return Redirect::to('web/driver/login-form')->send();
        }

        $users = DB::table('users')->where('email', $request->email)->first();

        if (Hash::check( $request->password, $users->password)) {
            Session::put('user_id', $users->id);
            Session::put('user_name', ucwords( $users->name) );
            Session::put('user_email', $users->email);
            Session::put('user_mobile', $users->mobile);
            //Session::put('designation', $users->designation);
            //Session::put('user_photo', $users->user_photo);
            Session::forget('error');
            return Redirect::to('web/driver/profile')->send();
        }else{
            Session::put('error', 'The password that you have entered is incorrect.');
            return Redirect::to('web/driver/login-form')->send();
        }
    }

    public static function login_auth_check(){
        $user_id = Session::get('user_id');
        if( $user_id == NULL ){
            return Redirect::to('web/driver/login-form')->send();
        }
    }

    public static function auth_check(){
        $user_id = Session::get('user_id');
        if( $user_id !== NULL ){
            return Redirect::to('/web/driver/profile')->send();
        }
    }

    public function logout(){
        Session::put('user_name', null);
        Session::put('user_id', null);

        return redirect('web/driver/login-form')->with('success', 'You are successfully logout!');
        //Session::put('success', 'You are successfully logout!');
        //return Redirect::to('/admin-login')->send();
    }

    public function profile(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'profile-content');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function my_earnings(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'my-earnings');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function trip_history(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'trip-history');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function upcoming_trips(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'upcoming-trips');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function tax_and_insurance(Request $request) {
        self::login_auth_check();

        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'tax-and-insurance');
        return view('web_api')->with('main_content', $manage_member);
    }

    public function edit_profile() {
        self::login_auth_check();
        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'edit-profile');

        return view('web_api')->with('main_content', $manage_member);
    }

    public function change_password() {
        self::login_auth_check();
        $manage_member = view('pages.web-driver.profile')->with('profile_content', 'change-password');
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
