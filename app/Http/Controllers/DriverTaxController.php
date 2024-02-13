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


class DriverTaxController extends Controller
{
    public function tax_management()
    {
        $tax_info = DB::table('driver_taxes')
            ->leftjoin('drivers', 'driver_taxes.driver_id', '=', 'driver_taxes.driver_id')
            ->leftjoin('vehicles', 'driver_taxes.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select('driver_taxes.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number')
            ->orderBy('created_at', 'DESC')->get();
        $manage_tax = view('pages.drivers.tax-management')->with('all_tax_info', $tax_info);

        return view('dashboard')->with('main_content', $manage_tax);
    }


    public function new_tax_save( Request $request)
    {
        $data = array(
            'vehicle_type_id'  => $request->vehicle_type_id,
            'tax_per_km'      => $request->tax_per_km,
            'waiting_tax'     => $request->waiting_tax,
            'minimum_tax'     => $request->minimum_tax,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->tax_note,
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('driver_taxes')->insert( $data );
        return redirect('/tax/tax-management')->with('success', 'Created New Fare Successfully!');
    }


    public function edit_tax(Request $request, $tax_id )
    {
        if ( $request->ajax() ) {
            $tax_info = DB::table('driver_taxes')->where('tax_id', $tax_id)->first();

            return response()->json( [$tax_info] );
        }
    }

    public function edit_tax_save( Request $request )
    {
        $tax_id = $request->tax_id;

        $data = array(
            'vehicle_id'       => $request->vehicle_id,
            'tax_per_km'      => $request->tax_per_km,
            'waiting_tax'     => $request->waiting_tax,
            'minimum_tax'     => $request->minimum_tax,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->tax_note,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('driver_taxes')->where('tax_id', $tax_id)->update( $data );

        return redirect('/tax/tax-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_tax( Request $request, $tax_id)
    {
        if ( $request->ajax() ) {
            DB::table('driver_taxes')->where('tax_id', $tax_id)->delete();
            return response()->json(['success' => 'Fare has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Fare', 'status' => 'failed']);
    }

    public function view_tax( Request $request, $tax_id )
    {
        if ( $request->ajax() ) {
            $view_tax = DB::table('driver_taxes')->where('tax_id', $tax_id )->first();
            return response()->json( array( $view_tax ) );
        }
    }
}
