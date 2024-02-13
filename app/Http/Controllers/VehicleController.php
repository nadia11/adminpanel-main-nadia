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


class VehicleController extends Controller
{
    public function vehicle_management()
    {
        $vehicle_info = DB::table('vehicles')
            ->leftjoin('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->select('vehicles.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'vehicle_types.vehicle_type', 'vehicle_types.seat_capacity', 'vehicle_types.vehicle_color', 'drivers.division_id')
            ->orderBy('created_at', 'DESC')->get();
        $manage_vehicle = view('pages.vehicles.vehicle-management')->with('all_vehicle_info', $vehicle_info);

        return view('dashboard')->with('main_content', $manage_vehicle);
    }

//    public function edit_vehicle(Request $request, $vehicle_id )
//    {
//        if ( $request->ajax() ) {
//            $vehicle_info = DB::table('vehicles')->where('vehicle_id', $vehicle_id)->first();
//            $driver = DB::table('drivers')->where('driver_id', $vehicle_info->driver_id)->select('driver_name', 'mobile')->first();
//
//            return response()->json( [$vehicle_info, 'driver'=>$driver] );
//        }
//    }
//
//    public function update_vehicle( Request $request )
//    {
//        $vehicle_id = $request->vehicle_id;
//
//        $data = array(
//            'client_id'       => $request->client_id,
//            'driver_id'     => $request->driver_id,
//            'vehicle_number'       => $request->vehicle_number,
//            'vehicle_date'         => Carbon::createFromFormat('d/m/Y', $request->vehicle_date )->format('Y-m-d H:i:s'),
//            'delivery_date'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date )->format('Y-m-d H:i:s'),
//            'project_name'    => $request->project_name,
//            'description'     => $request->description,
//            'job_status'      => $request->job_status,
//            'bill_status'     => 'bill_pending',
//            'vehicle_sub_total'    => $request->vehicle_sub_total,
//            'vehicle_vat_percent'  => $request->vehicle_vat_percent,
//            'vehicle_vat_amount'   => $request->vehicle_vat_amount,
//            'vehicle_amount'       => $request->vehicle_amount,
//            'advance_amount'  => $request->advance_amount,
//            'balance_amount'  => $request->balance_amount,
//            'vehicle_note'         => $request->vehicle_note,
//            'created_by'      => Auth::id(),
//            'created_at'      => date('Y-m-d H:i:s'),
//        );
//
//
//        if ($request->hasFile('vehicle_attachment')) {
//            $upload_dir = storage_path('client-vehicle/' );
//            $files = $request->file('vehicle_attachment');
//
//            $file_name_WithExt = $files->getClientOriginalName();
//            $extension = strtolower( $files->getClientOriginalExtension() );
//            $vehicle_attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
//            $success = $files->move( $upload_dir, $vehicle_attachment );
//
//            if( $request->vehicle_attachment_prev ){
//                //Storage::disk('local')->delete('client-vehicle/' . $request->vehicle_attachment_prev);.
//                if(file_exists($upload_dir . $request->vehicle_attachment_prev)) {
//                    unlink( $upload_dir . $request->vehicle_attachment_prev ); //delete previous image from upload folder
//                }
//            }
//            $data['vehicle_attachment'] = $vehicle_attachment;
//        }else{
//            $data['vehicle_attachment'] = $request->vehicle_attachment_prev;
//        }
//        DB::table('vehicles')->where('vehicle_id', $vehicle_id)->update( $data );
//
//        return redirect('/vehicle/vehicle-management')->with('success', 'Update Purchase Successfully!');
//    }


//    public function delete_vehicle( Request $request, $vehicle_id)
//    {
//        if ( $request->ajax() ) {
//            DB::table('vehicles')->where('vehicle_id', $vehicle_id)->delete();
//
//            $vehicle_item_ids = DB::table('purchase_order_items')->where('vehicle_id', $vehicle_id)->select('vehicle_item_id')->get();
//            foreach($vehicle_item_ids as $vehicle_item_id){
//                DB::table('purchase_order_items')->where('vehicle_item_id', $vehicle_item_id->vehicle_item_id)->delete();
//            }
//            return response()->json(['success' => 'Vehicle has been deleted successfully!', 'status' => 'success']);
//        }
//        return response(['error' => 'Failed deleting the Vehicle', 'status' => 'failed']);
//    }

//    public function change_vehicle_status(Request $request, $vehicle_id, $vehicle_status) {
//        if ( $request->ajax() ) {
//            DB::table('vehicles')->where('vehicle_id', $vehicle_id)->update( ['vehicle_status' => $vehicle_status ] );
//            return response()->json(['success' => 'Vehicle Status changed successfully!', 'status' => 'success', 'vehicle_status' => $vehicle_status, 'vehicle_id'=>$vehicle_id ]);
//        }
//    }

    public function view_vehicle( Request $request, $vehicle_id )
    {
        if ( $request->ajax() ) {
            $view_vehicle = DB::table('vehicles')->where('vehicle_id', $vehicle_id )->first();
            $driver_data = DB::table('drivers')->select('driver_id', 'driver_name', 'mobile')->where('driver_id', $view_vehicle->driver_id )->first();
            $vehicle_type_data = DB::table('vehicle_types')->select('vehicle_type','seat_capacity', 'vehicle_color', 'vehicle_photo')->where('vehicle_type_id', $view_vehicle->vehicle_type_id )->first();

            return response()->json( array( $view_vehicle, 'driver_data'=>$driver_data, 'vehicle_type_data'=>$vehicle_type_data) );
        }
    }


//    public function view_driver( Request $request, $driver_id )
//    {
//        if ( $request->ajax() ) {
//            $view_driver = DB::table('drivers')->where('driver_id', $driver_id )->first();
//            $division_name = DB::table('divisions')->where('division_id', $view_driver->division_id)->value('division_name');
//            $district_name = DB::table('districts')->where('district_id', $view_driver->district_id)->value('district_name');
//            $branch_data = DB::table('branches')->where('branch_id', $view_driver->branch_id)->select('branch_name', 'branch_address')->first();
//
//            return response()->json( array( $view_driver, 'division_name'=>$division_name, 'district_name'=>$district_name, 'branch'=>$branch_data) );
//        }
//    }
}
