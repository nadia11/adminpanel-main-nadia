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
use App\CustomClass\Sms;


class DriverController extends Controller
{
    public function driver_management()
    {
        $driver_info = DB::table('drivers')->orderBy('created_at', 'DESC')->get();
        $manage_driver = view('pages.drivers.driver-management')->with('all_driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }

    public function this_week_drivers()
    {
        $driver_info = DB::table('drivers')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
            ->orderBy('created_at', 'DESC')
            ->get();

        $manage_driver = view('pages.drivers.driver-management')->with('all_driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }

    public function unapproved_drivers()
    {
        $driver_info = DB::table('drivers')->where('approval_status', 'unapproved')->orderBy('created_at', 'DESC')->get();
        $manage_driver = view('pages.drivers.unapproved-drivers')->with('all_driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }

//    public function edit_driver(Request $request, $driver_id )
//    {
//        if ( $request->ajax() ) {
//            $driver_info = DB::table('drivers')->where('driver_id', $driver_id)->first();
//            $employee = DB::table('employees')->where('employee_id', $driver_info->employee_id)->select("designation_id",'employee_name', 'employee_mobile')->first();
//            $designation_name = DB::table('designations')->where('designation_id', $employee->designation_id)->value('designation_name');
//            $client_address = DB::table('clients')->where('client_id', $driver_info->client_id)->value('client_address');
//            $driver_items = DB::table('purchase_order_items')->where('driver_id', $driver_id)->get();
//            $in_word = taka_in_words(intval(  $driver_info->balance_amount, 0) );
//
//            return response()->json( [$driver_info, 'driver_items'=>$driver_items, 'in_word'=>$in_word, 'employee'=>$employee, 'designation_name'=>$designation_name, 'client_address'=>$client_address] );
//        }
//    }
//
//    public function update_driver( Request $request )
//    {
//        $driver_id = $request->driver_id;
//
//        $data = array(
//            'driver_id'       => $request->driver_id,
//            'employee_id'     => $request->employee_id,
//            'driver_number'       => $request->driver_number,
//            'driver_date'         => Carbon::createFromFormat('d/m/Y', $request->driver_date )->format('Y-m-d H:i:s'),
//            'delivery_date'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date )->format('Y-m-d H:i:s'),
//            'project_name'    => $request->project_name,
//            'description'     => $request->description,
//            'job_status'      => $request->job_status,
//            'bill_status'     => 'bill_pending',
//            'driver_sub_total'    => $request->driver_sub_total,
//            'driver_vat_percent'  => $request->driver_vat_percent,
//            'driver_vat_amount'   => $request->driver_vat_amount,
//            'driver_amount'       => $request->driver_amount,
//            'advance_amount'  => $request->advance_amount,
//            'balance_amount'  => $request->balance_amount,
//            'driver_note'         => $request->driver_note,
//            'created_by'      => Auth::id(),
//            'created_at'      => date('Y-m-d H:i:s'),
//        );
//
//
//        if ($request->hasFile('driver_attachment')) {
//            $upload_dir = storage_path('client-driver/' );
//            $files = $request->file('driver_attachment');
//
//            $file_name_WithExt = $files->getClientOriginalName();
//            $extension = strtolower( $files->getClientOriginalExtension() );
//            $driver_attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
//            $success = $files->move( $upload_dir, $driver_attachment );
//
//            if( $request->driver_attachment_prev ){
//                //Storage::disk('local')->delete('client-driver/' . $request->driver_attachment_prev);.
//                if(file_exists($upload_dir . $request->driver_attachment_prev)) {
//                    unlink( $upload_dir . $request->driver_attachment_prev ); //delete previous image from upload folder
//                }
//            }
//            $data['driver_attachment'] = $driver_attachment;
//        }else{
//            $data['driver_attachment'] = $request->driver_attachment_prev;
//        }
//        DB::table('drivers')->where('driver_id', $driver_id)->update( $data );
//
//        return redirect('/driver/driver-management')->with('success', 'Update Purchase Successfully!');
//    }


    public function delete_driver( Request $request, $driver_id)
    {
        if ( $request->ajax() ) {
            DB::table('drivers')->where('driver_id', $driver_id)->delete();
            return response()->json(['success' => 'Driver has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Driver', 'status' => 'failed']);
    }

    public function change_approval_status(Request $request) {
        if ( $request->ajax() ) {
            if($request->approval_status == "approved") {
                Sms::send_sms('Esojai Driver Approvals', $request->mobile, 'Congratulations! Your account has been approved. Now you can Login, get Ride & Earn Money.');

                DB::table('drivers')->where('driver_id', $request->driver_id)->update([
                    'approval_status' => $request->approval_status,
                    'driver_status' => "active"
                ]);
            } else {
                DB::table('drivers')->where('driver_id', $request->driver_id)->update([
                    'approval_status' => 'approved',
                    'driver_status' => $request->approval_status
                ]);
            }
            return response()->json(['success' => 'Driver Status changed successfully!', 'status' => 'success', 'approval_status' => $request->approval_status, 'driver_id'=>$request->driver_id ]);
        }
    }


    public function change_driver_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('drivers')->where('driver_id', $request->driver_id)->update( ['driver_status' => $request->driver_status ] );
            return response()->json(['success' => 'Driver Status changed successfully!', 'status' => 'success', 'driver_status' => $request->driver_status, 'driver_id'=>$request->driver_id ]);
        }
    }


    public function view_driver( Request $request, $driver_id )
    {
        if ( $request->ajax() ) {
            $view_driver = DB::table('drivers')->where('driver_id', $driver_id )->first();
            $division_name = DB::table('divisions')->where('division_id', $view_driver->division_id)->value('division_name');
            $district_name = DB::table('districts')->where('district_id', $view_driver->district_id)->value('district_name');
            $branch_data = DB::table('branches')->where('branch_id', $view_driver->branch_id)->select('branch_name', 'branch_address')->first();
            $vehicles = DB::table('vehicles')->where('driver_id', $driver_id)->first();
            $vehicle_types = DB::table('vehicle_types')->where('vehicle_type_id', $vehicles->vehicle_type_id ?? "")->select('vehicle_type_id', 'vehicle_type', 'seat_capacity', 'vehicle_color')->first();
            $trip_count = DB::table('driver_trips')->where('driver_id', $driver_id)->COUNT();

            return response()->json(array( $view_driver, 'division_name'=>$division_name, 'district_name'=>$district_name, 'branch'=>$branch_data, 'vehicles'=>$vehicles, 'vehicle_types'=>$vehicle_types, 'trip_count'=>$trip_count));
        }
    }

    public function view_driver_in_map($driver_id){
        $driver_info = DB::table('drivers')
            ->leftjoin('vehicles', 'drivers.driver_id', '=', 'vehicles.driver_id')
            ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicles.vehicle_type_id')
            ->select('drivers.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'vehicle_types.vehicle_type_id', 'vehicle_types.vehicle_type')
            ->where('drivers.driver_id', $driver_id)->first();

        $manage_driver = view('pages.maps.view-driver-in-map')->with('driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }
}
