<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Str;
use Session;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function index()
    {
        $login_content = view('user.login-content');
        return view('admin-login')->with('login_content', $login_content);
    }

    public function user_profile()
    {
        $profile = view('user.profile');
        return view('dashboard')->with('main_content', $profile);
    }

    public function update_profile()
    {
        $user_data = DB::table('users')->where('id', Auth::id())->first();
        $new_user = view('user.update-profile')->with('user_data', $user_data);

        return view('layouts.app')->with('login_content', $new_user);
    }

    public function update_profile_save( Request $request )
    {
        //dd($request->all());
        $user_id = $request->id;

        $user_data = array(
            'name'        => $request->name,
            'mobile'      => $request->mobile,
            'dob'         => Carbon::createFromFormat('d/m/Y', $request->dob )->format('Y-m-d H:i:s'),
            'email'       => $request->email,
            //'password'    => Hash::make( $request->password ),
            'updated_at'  => date('Y-m-d H:i:s')
        );


        if ($request->hasFile('user_photo')) {
            $upload_dir = upload_path('/user-photo/' );
            $files = $request->file('user_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $attachment );
            //$size       = $files->getSize();
            //$fileType   = $files->getClientMimeType();
            //$error = $files->getErrorMessage();

            if( $request->user_photo_prev ){
                //Storage::disk('local')->delete('user-photo/' . $request->user_photo_prev);.
                if(file_exists($upload_dir . $request->user_photo_prev)) {
                    unlink( $upload_dir . $request->user_photo_prev ); //delete previous image from upload folder
                }
            }
            $user_data['user_photo'] = $attachment;
        }else{
            $user_data['user_photo'] = $request->user_photo_prev;
        }
        DB::table('users')->where('id', $user_id)->update( $user_data );
        Session::flash('success', 'Update User Successfully!');
        return redirect('/user/user-profile')->with('success', 'Update User Successfully!');
    }


    public function changePassword(Request $request)
    {
        if ($request->isMethod('get'))
        {
            $user_data = DB::table('users')->where('id', Auth::id())->first();
            $change_password = view('user.change-password')->with('user_data', $user_data);

            return view('dashboard')->with('main_content', $change_password);

        } else {
//            $validator = Validator::make($request->all(), [
//                'old_password' => 'required',
//                'password' => 'required|confirmed',
//                'confirm_password' => 'required|confirmed'
//            ]);
//            if ($validator->fails()) {
//                return back()->withErrors($validator)->withInput();
//                //return array( 'fail' => true, 'errors' => $validator->getMessageBag()->toArray() );
//            }

            if (Hash::check( $request->old_password, Auth::user()->password)) {
                $user_data = array(
                    'password'   => Hash::make( $request->password ),
                    'updated_at' => date('Y-m-d H:i:s')
                );
                DB::table('users')->where('id', Auth::id())->update( $user_data );

                return redirect('/user/user-profile')->with('success', 'Password Updated Successfully!');
            } else {
                return back()->withErrors('Old Password is incorrect. Please try again!')->withInput();
                //return array( 'fail' => true, 'errors' => ["old_password" => "Old Password is incorrect. Please try again!"] );
            }
        }
    }

    public function upload_user_photo(Request $request)
    {
        if ($request->hasFile('user_photo')) {
            $files      = $request->file('user_photo');
            $file_name_WithExt   = $files->getClientOriginalName();
            $extension  = strtolower($files->getClientOriginalExtension());
            $file_name = Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) . "." . $extension;
            //$new_filename = uniqid() . '_' . time() . '.' . $extension;
            //$file_name = date('His') .'-'. Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) . "." . $extension;
            //$size       = $files->getSize();
            //$fileType   = $files->getClientMimeType();
            $dest_path = upload_path('/user-photo/');
            $success    = $files->move( $dest_path, $file_name );

            if ($success) {
                DB::table('users')->where('id', Auth::id() )->update( array('user_photo' => $file_name ) );
            } else {
                $error = $files->getErrorMessage();
            }
            return $file_name;
        }
    }

    public function remove_user_photo(Request $request)
    {
        if ( $request->ajax() ){
            $directory = 'user-photo/' . $request->user_photo;
            Storage::disk('uploads')->delete($directory);

            DB::table('users')->where('id', Auth::id() )->update( array('user_photo' => "" ) );
            return response()->json(['success' => 'User Photo has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the User Photo', 'status' => 'failed']);
    }


    //    public function login_check(Request $request)
//    {
//        $user_email = $request->user_email;
//        $user_password = $request->user_password;
//        //echo strlen($user_password);
//
//        $users = DB::table('users')
//                ->where('user_email', $user_email)
//                ->where('user_password', md5( $user_password))
//                ->first();
//
//        if( $users ){
//
//            //return view('admin.user_master'); //not use direct view, use redirect
//            Session::flash('id', $users->id);
//            Session::flash('name', ucwords( $users->name) );
//            Session::flash('email', $users->email);
//            Session::flash('mobile', $users->mobile);
//            Session::flash('user_photo', $users->user_photo);
//
//            return Redirect::to('/dashboard')->send();
//        }
//        else{
//            Session::flash('error', 'User ID or Password Invalid');
//            return Redirect::to('/admin-login')->send();
//        }
//    }

//    public static function auth_check()
//    {
//        //Check if already logged in
//        $user_id = Session::get('user_id');
//        if( $user_id == NULL ){
//            return Redirect::to('/admin-login')->send();
//        }
//    }
//
//    public function login_auth_check()
//    {
//        $user_id = Session::get('user_id');
//        if( $user_id !== NULL ){
//            return Redirect::to('/dashboard')->send();
//        }
//    }
//
//    public function logout(){
//        Session::flash('user_name', null);
//        Session::flash('user_id', null);
//
//        return redirect('/admin-login')->with('success', 'You are successfully logout!');
//        //Session::flash('success', 'You are successfully logout!');
//        //return Redirect::to('/admin-login')->send();
//    }


    public function lockscreen(Request $request)
    {
        if ($request->isMethod('get')){
            // only if user is logged in
            if(Auth::id()){
                session(['lockscreen' => true, 'uri' => url()->previous()]);
                //session(['success' => 'Account Locked Successfully!']);

                $lockscreen = view('user.lockscreen');
                return view('layouts.app')->with('login_content', $lockscreen);
                //return redirect('lockscreen')->with('success', 'Account Locked Successfully!');
            }
            return redirect('/login');
        }
        else{

            $validator = Validator::make($request->all(), [
                'password' => 'required|string',
            ]);
            if ($validator->fails()) {
                return back()->withErrors( $validator )->withErrors('Password does not match. Please try again.')->withInput();
                //return array( 'fail' => true, 'errors' => $validator->getMessageBag()->toArray() );
            }

            if(Hash::check($request->password, Auth::user()->password)){
                //Session::forget('lockscreen');
                //return redirect('/dashboard');

                $uri = $request->session()->get('uri');
                $uri_after_error = $uri == url('lockscreen' ) ? url('dashboard') : $uri;
                $request->session()->forget(['lockscreen', 'uri', 'success']);

                return redirect($uri_after_error)->with('success', 'Welcome Back! ' . auth()->user()->name);
            }
        }
    }

    public function user_account_settings()
    {
        if(DB::table('user_account_settings')->where('user_id', Auth::id())->doesntExist()){
            DB::table('user_account_settings')->where('user_id', Auth::id())->insert(array('currency' => "BDT", 'menu_position' => 'header_menu', 'language' => "en-us", 'theme' => "Light", 'user_id' => Auth::id(), 'created_at' => date('Y-m-d H:i:s') ));
            return redirect('/user/user-account-settings');
        }else{
            $ua_settings_data = DB::table('user_account_settings')->where('user_id', Auth::id())->first();
            $login_content = view('user.user-account-settings')->with('ua_settings_data', $ua_settings_data);
            return view('dashboard')->with('login_content', $login_content);
        }
    }

    public function user_account_settings_save( Request $request )
    {
        $exist = DB::table('user_account_settings')->where('user_id', Auth::id());
        $data = array(
            'currency'      => $request->currency,
            'menu_position' => $request->menu_position,
            'language'      => $request->language,
            'theme'         => $request->theme,
            'user_id'       => Auth::id(),
            'facebook'      => $request->facebook,
            'twitter'       => $request->twitter,
            'googleplus'    => $request->googleplus,
            'linkedin'      => $request->linkedin,
            'instagram'     => $request->instagram,
            'whatsapp'      => $request->whatsapp,
            'skype'         => $request->skype,
            'youtube'       => $request->youtube,
            'updated_at'    => date('Y-m-d H:i:s')
        );
        $exist->exists() ? $exist->update($data) : $exist->insert($data);

        return redirect('/user/user-profile')->with('success', 'Update Account Setting Successfully!');
    }
}
