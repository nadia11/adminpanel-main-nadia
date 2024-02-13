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


class DriverUpcomingTripController extends Controller
{
    public function driver_upcoming_trip()
    {
        $driver_upcoming_trip_info = DB::table('driver_upcoming_trips')
            ->leftjoin('drivers', 'driver_upcoming_trips.driver_id', '=', 'drivers.driver_id')
            ->select('driver_upcoming_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile')
            ->orderBy('created_at', 'DESC')->get();

        $manage_driver_upcoming_trip = view('pages.drivers.driver-upcoming-trip')->with('all_driver_upcoming_trip_info', $driver_upcoming_trip_info);

        return view('dashboard')->with('main_content', $manage_driver_upcoming_trip);
    }

    public function driver_upcoming_trip_route($trip_id){
//        $driver_upcoming_trip_info = DB::table('driver_upcoming_trips')
//            ->leftjoin('drivers', 'driver_upcoming_trips.driver_id', '=', 'drivers.driver_id')
//            ->select('driver_upcoming_trips.*', 'drivers.driver_name', 'drivers.mobile as driver_mobile')
//            ->where('trip_status', 'booked')->orderBy('created_at', 'DESC')->get();

        $manage_driver_upcoming_trip = view('pages.drivers.driver-trip-route')->with('all_driver_upcoming_trip_info', $driver_upcoming_trip_info);

        return view('dashboard')->with('main_content', $manage_driver_upcoming_trip);
    }

    public function new_driver_upcoming_trip_save( Request $request)
    {
//        dd($request->all());
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'client_id'       => $request->client_id,
            'employee_id'     => $request->employee_id,
            'trip_number'       => $request->trip_number,
            'trip_date'         => Carbon::createFromFormat('d/m/Y', $request->trip_date )->format('Y-m-d H:i:s'),
            'delivery_date'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date )->format('Y-m-d H:i:s'),
            'project_name'    => $request->project_name,
            'description'     => $request->description,
            'job_status'      => $request->job_status,
            'bill_status'     => 'bill_pending',
            'trip_sub_total'    => $request->trip_sub_total,
            'trip_vat_percent'  => $request->trip_vat_percent,
            'trip_vat_amount'   => $request->trip_vat_amount,
            'trip_amount'       => $request->trip_amount,
            'advance_amount'  => $request->advance_amount,
            'balance_amount'  => $request->balance_amount,
            'trip_note'         => $request->trip_note,
            'created_by'      => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('driver_upcoming_trips')->insert( $data );

        return redirect('/trip/trip-management')->with('success', 'Created New Purchase Successfully!');
    }

    public function delete_driver_upcoming_trip( Request $request, $trip_id)
    {
        if ( $request->ajax() ) {
            DB::table('driver_upcoming_trips')->where('trip_id', $trip_id)->delete();
            return response()->json(['success' => 'Trip has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Trip', 'status' => 'failed']);
    }
}
