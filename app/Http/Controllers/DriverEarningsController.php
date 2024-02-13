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


class DriverEarningsController extends Controller
{
    public function earning_management()
    {
        $earning_info = DB::table('driver_earnings')
            ->leftjoin('drivers', 'driver_earnings.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('vehicles', 'driver_earnings.vehicle_id', '=', 'vehicles.vehicle_id')
            ->leftjoin('vehicle_types', 'driver_earnings.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->select('driver_earnings.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number', 'vehicle_types.vehicle_type')
            ->orderBy('created_at', 'DESC')->get();

        $manage_earning = view('pages.drivers.driver-earnings')->with('all_earning_info', $earning_info);

        return view('dashboard')->with('main_content', $manage_earning);
    }


    public function specific_driver_earnings(Request $request)
    {
        $earning_info = DB::table('driver_earnings')
            ->leftjoin('drivers', 'driver_earnings.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('vehicles', 'driver_earnings.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select('driver_earnings.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number')
            ->where('driver_earnings.driver_id', $request->driver_id)
            ->orderBy('created_at', 'DESC')->get();

        $manage_earning = view('pages.drivers.driver-earnings')->with('all_earning_info', $earning_info);

        return view('dashboard')->with('main_content', $manage_earning);
    }


    public function new_earning_save(Request $request)
    {
        $data = array(
            'vehicle_type_id' => $request->vehicle_type_id,
            'earning_per_km' => $request->earning_per_km,
            'waiting_earning' => $request->waiting_earning,
            'minimum_earning' => $request->minimum_earning,
            'minimum_distance' => $request->minimum_distance,
            'note' => $request->earning_note,
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('driver_earnings')->insert($data);
        return redirect('/earning/earning-management')->with('success', 'Created New Insurance Successfully!');
    }


    public function edit_earning(Request $request, $earning_id)
    {
        if ($request->ajax()) {
            $earning_info = DB::table('driver_earnings')->where('earning_id', $earning_id)->first();

            return response()->json([$earning_info]);
        }
    }

    public function edit_earning_save(Request $request)
    {
        $earning_id = $request->earning_id;

        $data = array(
            'vehicle_id' => $request->vehicle_id,
            'earning_per_km' => $request->earning_per_km,
            'waiting_earning' => $request->waiting_earning,
            'minimum_earning' => $request->minimum_earning,
            'minimum_distance' => $request->minimum_distance,
            'note' => $request->earning_note,
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('driver_earnings')->where('earning_id', $earning_id)->update($data);

        return redirect('/earning/earning-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_earning(Request $request, $earning_id)
    {
        if ($request->ajax()) {
            DB::table('driver_earnings')->where('earning_id', $earning_id)->delete();
            return response()->json(['success' => 'Insurance has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Insurance', 'status' => 'failed']);
    }

    public function view_earning(Request $request, $earning_id)
    {
        if ($request->ajax()) {
            $view_earning = DB::table('driver_earnings')->where('earning_id', $earning_id)->first();
            return response()->json(array($view_earning));
        }
    }

    public function change_payment_status(Request $request)
    {
        if ( $request->ajax() ) {
            DB::table('driver_earnings')->where('driver_earning_id', $request->driver_earning_id)->update( ['payment_status' => $request->payment_status] );
            return response()->json( ['payment_status' => $request->payment_status, 'success'=> 'Change Status Successfully!'] );
        }
    }
}

