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


class MapController extends Controller
{
    public function view_in_map()
    {
        $driver_info = DB::table('drivers')->where('driver_status', 'pending')->orderBy('created_at', 'DESC')->get();
        $manage_driver = view('pages.maps.view-in-map')->with('all_driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }

    public function driver_live_tracking()
    {
        $driver_markers = DB::table('drivers')
            ->leftjoin('vehicles', 'drivers.driver_id', '=', 'vehicles.driver_id')
            ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->where('approval_status', 'approved')->whereIn('driver_status', ['online', 'on_trip'])
            ->select('drivers.driver_id', 'latitude', 'longitude', 'driver_status', 'vehicle_types.vehicle_type as vehicle_marker')->get();
        //->select('vehicles.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'vehicle_types.vehicle_type', 'vehicle_types.seat_capacity', 'vehicle_types.vehicle_color')

        $manage_driver = view('pages.maps.driver-live-tracking', compact('driver_markers'));
        return view('dashboard')->with('main_content', $manage_driver);
    }

    public function load_driver_markers(Request $request)
    {
        if ($request->ajax()) {
            $driver_markers = DB::table('drivers')
                ->leftjoin('vehicles', 'drivers.driver_id', '=', 'vehicles.driver_id')
                ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
                ->where('approval_status', 'approved')->whereIn('driver_status', ['online', 'on_trip'])
                ->select('drivers.driver_id', 'latitude', 'longitude', 'driver_status', 'vehicle_types.vehicle_type as vehicle_marker')->get();

            return response()->json($driver_markers);
        }
    }

    public function get_map_infowindow_content(Request $request, $driver_id)
    {
        if ($request->ajax()) {
            $drivers_info = DB::table('drivers')
                ->leftjoin('vehicles', 'drivers.driver_id', '=', 'vehicles.driver_id')
                ->leftjoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
                ->leftjoin('rider_trips', 'vehicles.driver_id', '=', 'rider_trips.driver_id')
                ->where('drivers.driver_id', $driver_id)
                ->select('drivers.driver_id', 'rider_trips.*', 'drivers.driver_status', 'drivers.latitude as driver_latitude', 'drivers.longitude as driver_longitude', 'drivers.driver_name', 'drivers.mobile as driver_mobile', 'vehicle_types.vehicle_type', 'vehicle_types.seat_capacity', 'vehicle_types.vehicle_color')->first();

            $driver_location = getAddress($drivers_info->driver_latitude, $drivers_info->driver_longitude, 'AIzaSyBzzTk-gzFStNFGDfSlS-H3HENq-ZAlkyQ');

            return response()->json(['drivers_info' => $drivers_info, 'driver_location' => $driver_location]);
        }
    }
}
