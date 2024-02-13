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


class RiderTripController extends Controller
{
    public function rider_all_trips()
    {
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile AS driver_mobile', 'riders.mobile AS rider_mobile')
            ->orderBy('created_at', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.rider-trips')->with('all_rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

    public function active_rider_trips(){
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.mobile AS rider_mobile')
            ->where('trip_status', 'active')->orderBy('created_at', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.rider-trips')->with('all_rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

    public function completed_rider_trips(){
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.mobile AS rider_mobile')
            ->where('trip_status', 'completed')->orderBy('created_at', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.rider-trips')->with('all_rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

    public function cancelled_rider_trips(){
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.mobile AS rider_mobile')
            ->where('trip_status', 'cancelled')->orderBy('created_at', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.rider-trips')->with('all_rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

    public function booked_rider_trips(){
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.mobile AS rider_mobile')
            ->where('trip_status', 'booked')->orderBy('created_at', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.rider-trips')->with('all_rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

    public function rider_trip_route($trip_number){
        $rider_trip_info = DB::table('rider_trips')
            ->leftjoin('vehicles', 'rider_trips.vehicle_id', '=', 'vehicles.vehicle_id')
            ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicles.vehicle_type_id')
            ->leftjoin('drivers', 'rider_trips.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('riders', 'rider_trips.rider_id', '=', 'riders.rider_id')
            ->select('rider_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'riders.rider_name', 'riders.mobile as rider_mobile', 'vehicle_types.vehicle_type_id', 'vehicle_types.vehicle_type', 'vehicles.vehicle_reg_number')
            ->where('trip_number', $trip_number)->first();

        $manage_rider_trip = view('pages.maps.rider-trip-route')->with('rider_trip_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }

//    public function delete_rider_trip( Request $request, $trip_id)
//    {
//        if ( $request->ajax() ) {
//            DB::table('rider_trips')->where('trip_id', $trip_id)->delete();
//            return response()->json(['success' => 'Trip has been deleted successfully!', 'status' => 'success']);
//        }
//        return response(['error' => 'Failed deleting the Trip', 'status' => 'failed']);
//    }

    public function searching_trips()
    {
        $rider_trip_info = DB::table('searching_trips')
            ->leftjoin('riders', 'searching_trips.rider_id', '=', 'riders.rider_id')
            ->select('searching_trips.*', 'riders.mobile AS rider_mobile', 'riders.rider_name')
            ->orderBy('searching_time', 'DESC')->get();
        $manage_rider_trip = view('pages.riders.searching-trips')->with('all_searching_info', $rider_trip_info);

        return view('dashboard')->with('main_content', $manage_rider_trip);
    }
}
