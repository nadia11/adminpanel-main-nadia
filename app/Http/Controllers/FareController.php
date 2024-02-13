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


class FareController extends Controller
{
    public function fare_management()
    {
        $fare_info = DB::table('fares')
            ->leftjoin('vehicle_types', 'fares.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->select('fares.*', 'vehicle_types.vehicle_type')
            ->orderBy('vehicle_type', 'ASC')
            ->orderBy('period_type', 'ASC')
            ->get();
        $manage_fare = view('pages.fares.fare-management')->with('all_fare_info', $fare_info);

        return view('dashboard')->with('main_content', $manage_fare);
    }


    public function new_fare_save( Request $request)
    {
        $data = array(
            'vehicle_type_id'         => $request->vehicle_type_id,
            'minimum_fare'            => $request->minimum_fare,
            'fare_per_km'             => $request->fare_per_km,
            'waiting_fare'            => $request->waiting_fare,
            'minimum_distance'        => $request->minimum_distance,
            'destination_change_fee'  => $request->destination_change_fee,
            'delay_cancellation_fee'  => $request->delay_cancellation_fee,
            'delay_cancellation_minute' => $request->delay_cancellation_minute,
            'period_type'             => $request->period_type,
            'start_time'              => $request->start_time,
            'end_time'                => $request->end_time,
            'note'                    => $request->fare_note,
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('fares')->insert( $data );

        return redirect('/fare/fare-management')->with('success', 'Created New Fare Successfully!');
    }


    public function edit_fare(Request $request, $fare_id )
    {
        if ( $request->ajax() ) {
            $fare_info = DB::table('fares')->where('fare_id', $fare_id)->first();

            return response()->json( [$fare_info] );
        }
    }

    public function edit_fare_save( Request $request )
    {
        $fare_id = $request->fare_id;

        $data = array(
            'vehicle_type_id'         => $request->vehicle_type_id,
            'minimum_fare'            => $request->minimum_fare,
            'fare_per_km'             => $request->fare_per_km,
            'waiting_fare'            => $request->waiting_fare,
            'minimum_distance'        => $request->minimum_distance,
            'destination_change_fee'  => $request->destination_change_fee,
            'delay_cancellation_fee'  => $request->delay_cancellation_fee,
            'delay_cancellation_minute' => $request->delay_cancellation_minute,
            'period_type'             => $request->period_type,
            'start_time'              => $request->start_time,
            'end_time'                => $request->end_time,
            'note'                    => $request->fare_note,
            'created_at'              => date('Y-m-d H:i:s'),
        );
        DB::table('fares')->where('fare_id', $fare_id)->update( $data );

        return redirect('/fare/fare-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_fare( Request $request, $fare_id)
    {
        if ( $request->ajax() ) {
            DB::table('fares')->where('fare_id', $fare_id)->delete();
            return response()->json(['success' => 'Fare has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Fare', 'status' => 'failed']);
    }

    public function view_fare( Request $request, $fare_id )
    {
        if ( $request->ajax() ) {
            $view_fare = DB::table('fares')->where('fare_id', $fare_id )->first();
            return response()->json( array( $view_fare ) );
        }
    }
}
