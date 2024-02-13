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


class AgentController extends Controller
{
    public function agent_management()
    {
        $agent_info = DB::table('agents')
            ->join('districts', 'agents.district_id', '=', 'districts.district_id')
            ->select('agents.*', 'districts.district_name')
            ->orderBy('created_at', 'DESC')->get();

        $manage_agent = view('pages.agents.agent-management')->with('all_agent_info', $agent_info);

        return view('dashboard')->with('main_content', $manage_agent);
    }


    public function new_agent_save( Request $request)
    {
//        dd($request->all());
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
        $max_id = DB::table('agents')->max('agent_id'); $sh_max_id = $max_id < 1 ? '01' : ($max_id <= 9 ? "0". ($max_id + 1) : $max_id + 1);

//        $user_data = array(
//            'name'       => $request->agent_name,
//            'email'      => $request->email,
//            'mobile'     => $request->mobile,
//            'password'   => bcrypt($request->password),
//            'role_id'    => 6, /***Driver role**/
//            'status'     => "pending",
//            'created_at' => date('Y-m-d H:i:s'),
//        );
//        if ($request->hasFile('agent_photo')) {
//            $upload_dir = storage_path('uploads/user-photo' );
//            $files = $request->file('agent_photo');
//
//            $file_name_WithExt = $files->getClientOriginalName();
//            $extension = strtolower( $files->getClientOriginalExtension() );
//            $file_name = "sh_photo_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".".$extension;
//            $success = $files->move( $upload_dir, $file_name );
//
//            $user_data['user_photo'] = $file_name;
//        }
//        $user_id = DB::table('users')->insertGetId( $user_data );

        $data = array(
            //'user_id'          => $user_id,
            'agent_name' => $request->agent_name,
            'fathers_name'     => $request->fathers_name,
            'mothers_name'     => $request->mothers_name,
            'country_name'     => "Bangladesh",
            'division_id'      => $request->division_id,
            'district_id'      => $request->district_id,
            'branch_name'      => $request->branch_name,
            'branch_address'   => $request->branch_address,
            'date_of_birth'    => Carbon::createFromFormat('d/m/Y', $request->date_of_birth )->format('Y-m-d H:i:s'),
            'blood_group'      => $request->blood_group,
            'gender'           => $request->gender,
            'mobile'           => $request->mobile,
            'alt_mobile'       => $request->alt_mobile,
            'religion'         => $request->religion,
            'nationality'      => $request->nationality,
            'national_id'      => $request->national_id,
            'email'            => $request->email,
            'password'         => bcrypt($request->password),
            'trade_licence_number' => $request->trade_licence_number,
            'tin_number'       => $request->tin_number,
            'vat_number'       => $request->vat_number,
            'latitude'         => number_format($request->latitude, 7),
            'longitude'        => number_format($request->longitude, 7),
            'note'             => $request->note,
            'agent_status' => "pending",
            'reg_date'         => date('Y-m-d H:i:s'),
            'created_at'       => date('Y-m-d H:i:s'),
        );


        if ($request->hasFile('agent_photo')) {
            $upload_dir = upload_path('/agents' );
            $files = $request->file('agent_photo');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "sh_photo_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['agent_photo'] = $file_name;
        }

        if ($request->hasFile('trade_licence')) {
            $upload_dir = upload_path('/agents' );
            $files = $request->file('trade_licence');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "sh_trade_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['trade_licence'] = $file_name;
        }

        if ($request->hasFile('nid_copy')) {
            $upload_dir = upload_path('/agents' );
            $files = $request->file('nid_copy');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "sh_nid_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['nid_copy'] = $file_name;
        }

        if ($request->hasFile('tin_certificate')) {
            $upload_dir = upload_path('/agents' );
            $files = $request->file('tin_certificate');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "sh_tin_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['tin_certificate'] = $file_name;
        }

        if ($request->hasFile('vat_certificate')) {
            $upload_dir = upload_path('/agents' );
            $files = $request->file('vat_certificate');
            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $file_name = "sh_vat_".$sh_max_id."_".Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) .".". $extension;
            $success = $files->move( $upload_dir, $file_name );

            $data['vat_certificate'] = $file_name;
        }

        DB::table('agents')->insert( $data );
        return redirect('/agent/agent-management')->with('success', 'Created New Agent Successfully!');
    }

    public function edit_agent(Request $request, $agent_id )
    {
        if ( $request->ajax() ) {
            $agent_info = DB::table('agents')->where('agent_id', $agent_id)->first();
            $district_name = DB::table('districts')->where('district_id', $agent_info->district_id)->value('district_name');

            return response()->json( [$agent_info, 'district_name'=>$district_name ] );
        }
    }


    public function edit_agent_save( Request $request )
    {
        $data = array(
            'agent_name' => $request->agent_name,
            'fathers_name'     => $request->fathers_name,
            'mothers_name'     => $request->mothers_name,
            'country_name'     => "Bangladesh",
            'division_id'      => $request->division_id,
            'district_id'      => $request->district_id,
            'branch_name'      => $request->branch_name,
            'branch_address'   => $request->branch_address,
            'date_of_birth'    => Carbon::createFromFormat('d/m/Y', $request->date_of_birth )->format('Y-m-d H:i:s'),
            'blood_group'      => $request->blood_group,
            'gender'           => $request->gender,
            'mobile'           => $request->mobile,
            'religion'         => $request->religion,
            'nationality'      => $request->nationality,
            'national_id'      => $request->national_id,
            'email'            => $request->email,
            //'password'         => bcrypt($request->password),
            'trade_licence_number' => $request->trade_licence_number,
            'tin_number'       => $request->tin_number,
            'vat_number'       => $request->vat_number,
            'latitude'         => $request->latitude,
            'longitude'        => $request->longitude,
            'note'             => $request->note,
            'agent_status' => "pending",
            'reg_date'         => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s')
        );


//        if ($request->hasFile('agent_attachment')) {
//            $upload_dir = storage_path('client-agent/' );
//            $files = $request->file('agent_attachment');
//
//            $file_name_WithExt = $files->getClientOriginalName();
//            $extension = strtolower( $files->getClientOriginalExtension() );
//            $agent_attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
//            $success = $files->move( $upload_dir, $agent_attachment );
//
//            if( $request->agent_attachment_prev ){
//                //Storage::disk('local')->delete('client-agent/' . $request->agent_attachment_prev);.
//                if(file_exists($upload_dir . $request->agent_attachment_prev)) {
//                    unlink( $upload_dir . $request->agent_attachment_prev );
//                }
//            }
//            $data['agent_attachment'] = $agent_attachment;
//        }else{
//            $data['agent_attachment'] = $request->agent_attachment_prev;
//        }
        DB::table('agents')->where('agent_id', $request->agent_id)->update( $data );

        return redirect('/agent/agent-management')->with('success', 'Update Agent Successfully!');
    }


    public function delete_agent( Request $request, $agent_id)
    {
        if ( $request->ajax() ) {
            $picture = DB::table('agents')->where('agent_id', $agent_id)->value('agent_photo');
            if ($picture){
                Storage::disk('public')->delete('/uploads/agents/'.$picture);
                //Storage::disk('uploads')->delete('/agents/'.$picture);
                //unlink( upload_path('/agents/' ) . $picture );
            }
            DB::table('agents')->where('agent_id', $agent_id)->delete();

            return response()->json(['success' => 'Agent has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Agent', 'status' => 'failed']);
    }

    public function change_agent_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('agents')->where('agent_id', $request->agent_id)->update( ['agent_status' => $request->agent_status ] );
            return response()->json(['success' => 'Agent Status changed successfully!', 'status' => 'success', 'agent_status' => $request->agent_status, 'agent_id'=>$request->agent_id ]);
        }
    }

//    public function check_agent(Request $request, $agent_number)
//    {
//        if ( $request->ajax() ) {
//            $agent_number = DB::table('agents')->where('agent_number', $agent_number)->exists();
//            return response()->json( $agent_number );
//        }
//    }

    public function view_agent( Request $request, $agent_id )
    {
        if ( $request->ajax() ) {
            $view_agent = DB::table('agents')->where('agent_id', $agent_id )->first();
            $division_name = DB::table('divisions')->where('division_id', $view_agent->division_id)->value('division_name');
            $district_name = DB::table('districts')->where('district_id', $view_agent->district_id)->value('district_name');
            $branch_data = DB::table('branches')->where('branch_id', $view_agent->branch_id)->select('branch_name', 'branch_address')->first();

            return response()->json( array( $view_agent, 'division_name'=>$division_name, 'district_name'=>$district_name, 'branch'=>$branch_data) );

        }
    }

}
