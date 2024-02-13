<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use Mail;
use url;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;


class UserManageByAdminController extends Controller
{
    public function user_management()
    {
        $user_data = DB::table('users')->join('user_roles', 'users.role_id', '=', 'user_roles.role_id')->select('users.*', 'user_roles.role_name')->get();
        $user_management = view('user.user-manage-by-admin.user-management')->with('user_data', $user_data);

        return view('dashboard')->with('main_content', $user_management);
    }

    public function user_management_ajax() {
        $user_data = DB::table('users')->join('user_roles', 'users.role_id', '=', 'user_roles.role_id')->select('users.*', 'user_roles.role_name')->get();
        $user_management = view('user.user-manage-by-admin.user-management-ajax')->with('user_data', $user_data);

        return view('dashboard')->with('main_content', $user_management);
    }

    public function user_management_list_data(Request $request)
    {
        $datatable_query = DB::table('users')
            ->leftJoin('user_roles', 'users.role_id', '=', 'user_roles.role_id')
            ->select('users.id AS user_id', 'users.name AS user_name', 'users.mobile', 'users.email', 'users.role_id', 'users.status AS user_status', 'users.user_photo', 'user_roles.role_name')
            ->orderBy('user_roles.role_name', 'ASC');

        $totalData = $datatable_query->count();
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $limit = $request->input('length'); //Rows display per page filter
        $columnIndex = $request['order'][0]['column']; //Column index dynamic
        $order = $request['columns'][$columnIndex]['data']; //Column name dynamic
        $dir = $request->input('order.0.dir'); //asc or desc
        $search_value = $request['search']['value']; //$request->input('search.value');


        /*************user_filter_from_url************/
        //if( $request->role_name_filter_from_url ) {
        //    $datatable_query->where('user_roles.role_name', null)->orWhere('user_roles.role_name', "")->get();
        //    $totalFiltered = $datatable_query->count();
        //}
        if( $request->user_role_filter ) {
            $datatable_query->where('role_name', $request->user_role_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->user_status_filter ) {
            $datatable_query->where('status', $request->user_status_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->blood_group_filter ) {
            $datatable_query->where('blood_group', $request->blood_group_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if( $request->gender_filter ) {
            $datatable_query->where('gender', $request->gender_filter)->get();
            $totalFiltered = $datatable_query->count();
        }

        if ( isset($request['search']) && $search_value != '' ) {
            $datatable_query->where('user_name', 'LIKE', "%{$search_value}%")
                ->orWhere('mobile', 'LIKE', "%{$search_value}%")
                ->orWhere('email', 'LIKE', "%{$search_value}%")
                ->orWhere('role_name', 'LIKE', "%{$search_value}%")
                ->orWhere('user_status', 'LIKE', "%{$search_value}%")
                //->orWhere('status', 'LIKE', "%{$search_value}%")
                ->get();

            $totalFiltered = $datatable_query->count();
        }

        if ( isset($request['order']) && count($request['order']) ) {
            $datatable_query->orderBy($order, $dir)->get();
        }

        /******* 1 lac pcs********/
        if ( isset($request['start']) && $request['length'] === 1000000 ) {
            $datatable_query->offset($request['start'])->limit($request['length'])->get();
        }

        /*******Total number of records without filtering*****/
        $table_generate_data = $datatable_query->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = array();
        $status_class = array('pending'=>'btn-warning', 'denied'=>'badge-danger', 'active'=>'badge-success', 'approved'=>'badge-success',);
        if(!empty($table_generate_data)){
            foreach ($table_generate_data as $key=>$row)
            {
                $nestedData['DT_RowClass'] = "row_".$row->user_id . ($row->user_status == 'Expired' ? ' bg-expired' : "");
                //$nestedData['user_id']     = $key+1+$start; /*Index Column*/
                //$nestedData['row_checkbox']   = '<td><input type="checkbox" data-href="'. URL::to( '/admin/delete-selected-user') .'" name="id[]" id="'.$row->user_id.'" class="filled-in" value="'.$row->user_id.'" /><label for="'.$row->user_id.'"></label></td>';
                $nestedData['user_name']   = str_snack($row->user_name);
                $nestedData['mobile']      = $row->mobile ?? "-";
                $nestedData['email']       = $row->email ?? "-";
                $nestedData['role_name']       = str_snack($row->role_name) ?? "-";
                $nestedData['user_status'] = '<button type="button" class="btn btn-sm change-status '.$status_class[$row->user_status].'" id="'.$row->user_id.'">'.str_snack($row->user_status).'</button>';
                $nestedData['online_status'] = Cache::has('user-is-online-'.$row->user_id) ? '<span class="online-indicator">Online</span>' : '<span class="text-mute">Offline</span>';
                $nestedData['user_photo']  = '<img src="'. (!empty($row->user_photo) ? upload_url( "/user-photo/". $row->user_photo ) : image_url('defaultAvatar.jpg')) .'" style="border-radius: 50%; width: 40px; height: 40px; border: 1px solid #eee; box-shadow: 0 0 3px rgba(0,0,0,.3); padding: 1px; margin: 0px;" />';

                $nestedData['action']      = '<button type="button" class="btn btn-info btn-sm view-user" id="'.$row->user_id.'" data-url="'. url("/admin/view-user/" . $row->user_id) .'"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                $nestedData['action']      .= '<button type="button" class="btn btn-dark btn-sm changePasswordByadmin" id="'.$row->user_id.'"><i class="fa fa-sync-alt fa-spin" aria-hidden="true"></i></button>';
                $nestedData['action']      .= '<button type="button" class="btn btn-warning btn-sm editUser" id="'.$row->user_id.'"><i class="fa fa-edit" aria-hidden="true"></i></button>';
                $nestedData['action']      .= '<button type="button" class="btn btn-danger btn-sm ajaxDelete"'. ($row->email == Auth::user()->email ? 'disabled="disabled"' : "") .' data-href="'. URL::to( "/admin/delete-user/" . $row->user_id) .'" data-title="'. $row->user_name .'" id="'.$row->user_id.'"><i class="fa fa-trash" aria-hidden="true"></i></button>';

                //if(is_user_role('SpecialSuperAdmin')) {
                //    $nestedData['action']  .= '<button type="button" class="btn btn-dark btn-sm editMemberTemporary" id="'.$row->user_id.'" data-toggle="tooltip" data-placement="top" title="Edit this Member"><i class="fa fa-edit"></i></button>';
                //}

                //Final data
                $data[]      = $nestedData;
            }
        }
        $json_data = array(
            "draw"            => isset ( $request['draw'] ) ? intval($request->input('draw')) : 0,
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        return response()->json($json_data);
    }


    public function new_user_save(Request $request)
    {
        $data = array(
            'name'            => $request->username,
            'mobile'          => $request->mobile,
            'role_id'         => $request->role_id,
            'dob'             => Carbon::createFromFormat('d/m/Y', $request->dob )->format('Y-m-d H:i:s'),
            'email'           => $request->email,
            'password'        => Hash::make( $request->password ),
            'gender'          => $request->gender,
            'nid'             => $request->national_id,
            'status'          => 'Pending',
            'activation_key'  => '0',
            'user_start_time' => $request->user_start_time,
            'user_end_time'   => $request->user_end_time,
            'device'          => get_device(),
            'ip_access'       => $request->ip_access,
            'ip_address'      => $request->ip_address, //$request->ip(), $_SERVER['REMOTE_ADDR'], $request->ip_address, $clientIP = \Request::ip();, $clientIP = \Request::getClientIp(true);
            'mac_address'     => $request->mac_address, //get_mac_address(),
            'created_at'      => date('Y-m-d H:i:s')
        );


        if ($request->hasFile('user_photo')) {
            $upload_dir = upload_path('user-photo/' );
            $files = $request->file('user_photo');
            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $attachment );
            $data['user_photo'] = $attachment;
            //$size       = $files->getSize();
            //$fileType   = $files->getClientMimeType();
            //$file_name = date('His') .'-'. Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) . "." . $extension;

            if( $success ){
                //Mail if success
                $email_data = array(
                    'name'     => $request->name,
                    'email'    => $request->email,
                    'subject'       => 'New User Created successfully!',
                    'message_body'  => $request->name . " " . $request->email,
                    'activation_link' => '<a href="#">activation_link</a>',
                );

                Mail::send('user.new-user-mail', $email_data, function($message) use ($email_data){
                    $message->from( $email_data['name'] );
                    //$message->from(env('ADMIN_MAIL'));
                    $message->to( 'mhrabiul2009@gmail.com' );
                    $message->cc( 'mhrabiul2009@gmail.com' );
                    $message->bcc( 'mhrabiul2009@gmail.com' );
                    $message->subject( $email_data['subject'] );
                    //$message->greeting(sprintf('Hello %s', $user->name));
                    //$message->line('You have successfully registered to our system. Please activate your account.');
                    //$message->action('Click Here', route('activate.user', $user->activation_code));
                    //$message->line('Thank you for using our application!');
                });
            }else{
                $error = $files->getErrorMessage();
            }
        }
        DB::table('users')->insert( $data );
        return redirect('/admin/user-management')->with('success', 'Created New Users Successfully!');
    }

    public function edit_user( Request $request, $user_id ) {
        if ( $request->ajax() )        {
            $user_data = DB::table('users')->where('id', $user_id)->first();
            return response()->json( [$user_data] );
        }
    }

    public function update_user_save( Request $request )
    {
        if ( $request->ajax() ){
            $user_data = array(
                'name'            => $request->username,
                'mobile'          => $request->mobile,
                'role_id'         => $request->role_id,
                'dob'             => Carbon::createFromFormat('d/m/Y', $request->dob )->format('Y-m-d H:i:s'),
                'email'           => $request->email,
                'gender'          => $request->gender,
                'nid'             => $request->national_id,
                'user_start_time' => $request->user_start_time,
                'user_end_time'   => $request->user_end_time,
                'device'          => get_device(),
                'ip_access'       => $request->ip_access,
                'ip_address'      => $request->ip_address, //$request->ip(), $_SERVER['REMOTE_ADDR'], $request->ip_address, $clientIP = \Request::ip();, $clientIP = \Request::getClientIp(true);
                'mac_address'     => $request->mac_address, //get_mac_address(),
                'updated_at'      => date('Y-m-d H:i:s')
            );


            if ($request->hasFile('user_photo')) {
                $upload_dir = upload_path('user-photo/' );
                $files = $request->file('user_photo');

                $file_name_WithExt = $files->getClientOriginalName();
                $extension = strtolower( $files->getClientOriginalExtension() );
                $attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
                $success = $files->move( $upload_dir, $attachment );

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
            DB::table('users')->where('id', $request->user_id)->update( $user_data );
            return response()->json(['success' => $request->username . ' is updated Successfully!', 'status' => 'success', $user_data]);
        }
        return response(['error' => 'Failed updating the User', 'status' => 'failed']);
    }


    public function changePassword(Request $request )
    {
        if ( $request->ajax() ) {
            $validator = Validator::make($request->all(), [
                'password' => 'required',
                'confirm_password' => 'required'
            ]);
            if ($validator->fails()) {
                //return back()->withErrors($validator)->withInput();
                return array( 'fail' => true, 'errors' => $validator->getMessageBag()->toArray() );
            }
            DB::table('users')->where('id', $request->user_id)->update(['password' => Hash::make( $request->password ), 'updated_at'=> date('Y-m-d H:i:s')]);
            return response()->json(['success' => 'Password change Successfully!!', 'status' => 'success']);
        }
        return response(['error' => 'Failed to chanting Password', 'status' => 'failed']);
    }


    public function change_status(Request $request)
    {
        if ( $request->ajax() ) {
            DB::table('users')->where('id', $request->user_id )->update(['status'=>$request->user_status]);

            return response()->json( ['status' => $request->user_status, 'id'=>$request->user_id, 'success'=> $request->user_status . ' User Successfully!'] );
        }
        return response(['success' => 'Failed changing the User', 'status' => 'failed']);
    }

    public function view_user( Request $request, $user_id )
    {
        if ( $request->ajax() ) {
            $view_users = DB::table('users')->where('id', $user_id )->first();
            $role_name = DB::table('user_roles')->where('role_id', $view_users->role_id )->value('role_name');

            return response()->json([$view_users, 'role_name'=>$role_name ]);
        }
    }

    public function delete_user(Request $request, $user_id )
    {
        if ( $request->ajax() ) {
            DB::table('users')->where('id', $user_id )->delete();
            $user_photo = DB::table('users')->where('id', $user_id )->value('user_photo');
            $user_photo_url = strtolower("/user-photo/". $user_photo );
            Storage::disk('uploads')->delete($user_photo_url);

            return response()->json(['success' => 'Delete User Successfully!!', 'status' => 'success']);
        }
        return response(['success' => 'Failed deleting the User', 'status' => 'failed']);
    }

    public function delete_selected_user(Request $request )
    {
        if ( $request->ajax() ){
            foreach ($request->ids as $id){
                DB::table('users')->where('id', $id )->delete();

                $user_photo = DB::table('users')->where('id', $id )->value('user_photo');
                $user_photo_url = strtolower("/user-photo/". $user_photo );
                Storage::disk('uploads')->delete($user_photo_url);
            }
            return response()->json(['success' => 'Delete User Successfully!!', 'status' => 'success', 'ids'=>$request->ids]);
        }
        return response(['success' => 'Failed deleting the User', 'status' => 'failed']);
    }




    /***********************************
     * Role List
     * *********/
    public function new_role_save(Request $request)
    {
        if ( $request->ajax() ) {
            $data = array(
                'role_name'  => $request->role_name,
                'role_description' => $request->role_description,
                'created_at'    => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('user_roles')->insertGetId( $data );
            $data['role_id'] = $lastId;

            return response()->json(['success' => 'Save role Successfully!', 'status' => 'success', $data ]);
        }
    }

    public function edit_role(Request $request, $role_id)
    {
        if ( $request->ajax() ) {
            $role_info = DB::table('user_roles')->where('role_id', $role_id)->first();
            return response()->json( $role_info );
        }
    }

    public function update_role( Request $request )
    {
        if ( $request->ajax() ) {
            $role_id = $request->id;

            $data = array(
                'role_name'  => $request->role_name,
                'role_description' => $request->role_description,
                'updated_at'    => date('Y-m-d H:i:s'),
            );
            DB::table('user_roles')->where('role_id', $role_id)->update( $data );

            $data['role_id'] = $role_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function cancel_update_role(Request $request)
    {
        if ( $request->ajax() ) {
            $role_info = DB::table('user_roles')->where('role_id', $request->role_id)->first();

            return response()->json( $role_info );
        }
    }


    public function delete_role( Request $request, $role_id)
    {
        if ( $request->ajax() ) {
            DB::table('user_roles')->where('role_id', $role_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the role', 'status' => 'failed']);
    }

    public function role_wise_users( $role_id )
    {
        $user_data = DB::table('users')
            ->join('user_roles', 'users.role_id', '=', 'user_roles.role_id')
            ->select('users.*', 'user_roles.role_name')
            ->where('users.role_id', $role_id)
            ->get();
        return view('user.user-manage-by-admin.role-wise-users')->with('user_data', $user_data);
    }

    public function login_logs()
    {
        $login_logs = DB::table('login_logs')
            ->join('users', 'login_logs.user_id', '=', 'users.id')
            ->select('login_logs.*', 'users.name as user_name')
            ->orderBy('login_logs.created_at', 'DESC')
            ->get();

        $login_log_data = view('user.user-manage-by-admin.login-logs')->with('login_logs', $login_logs);

        return view('dashboard')->with('main_content', $login_log_data);
    }
}
