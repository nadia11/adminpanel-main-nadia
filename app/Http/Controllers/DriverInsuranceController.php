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


class DriverInsuranceController extends Controller
{
    public function insurance_management()
    {
        $insurance_info = DB::table('driver_insurances')
            ->leftjoin('drivers', 'driver_insurances.driver_id', '=', 'driver_insurances.driver_id')
            ->leftjoin('vehicles', 'driver_insurances.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select('driver_insurances.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number')
            ->orderBy('created_at', 'DESC')->get();

        $manage_insurance = view('pages.drivers.insurance-management')->with('all_insurance_info', $insurance_info);

        return view('dashboard')->with('main_content', $manage_insurance);
    }


    public function new_insurance_save( Request $request)
    {
        $data = array(
            'vehicle_type_id'  => $request->vehicle_type_id,
            'insurance_per_km'      => $request->insurance_per_km,
            'waiting_insurance'     => $request->waiting_insurance,
            'minimum_insurance'     => $request->minimum_insurance,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->insurance_note,
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('driver_insurances')->insert( $data );
        return redirect('/insurance/insurance-management')->with('success', 'Created New Insurance Successfully!');
    }


    public function edit_insurance(Request $request, $insurance_id )
    {
        if ( $request->ajax() ) {
            $insurance_info = DB::table('driver_insurances')->where('insurance_id', $insurance_id)->first();

            return response()->json( [$insurance_info] );
        }
    }

    public function edit_insurance_save( Request $request )
    {
        $insurance_id = $request->insurance_id;

        $data = array(
            'vehicle_id'       => $request->vehicle_id,
            'insurance_per_km'      => $request->insurance_per_km,
            'waiting_insurance'     => $request->waiting_insurance,
            'minimum_insurance'     => $request->minimum_insurance,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->insurance_note,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('driver_insurances')->where('insurance_id', $insurance_id)->update( $data );

        return redirect('/insurance/insurance-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_insurance( Request $request, $insurance_id)
    {
        if ( $request->ajax() ) {
            DB::table('driver_insurances')->where('insurance_id', $insurance_id)->delete();
            return response()->json(['success' => 'Insurance has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Insurance', 'status' => 'failed']);
    }

    public function view_insurance( Request $request, $insurance_id )
    {
        if ( $request->ajax() ) {
            $view_insurance = DB::table('driver_insurances')->where('insurance_id', $insurance_id )->first();
            return response()->json( array( $view_insurance ) );
        }
    }
}
