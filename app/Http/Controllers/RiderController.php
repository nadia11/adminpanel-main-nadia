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


class RiderController extends Controller
{
    public function rider_management()
    {
        $rider_info = DB::table('riders')->orderBy('created_at', 'DESC')->get();
        $manage_rider = view('pages.riders.rider-management')->with('all_rider_info', $rider_info);

        return view('dashboard')->with('main_content', $manage_rider);
    }

    public function this_week_riders()
    {
        $rider_info = DB::table('riders')
            ->whereBetween('created_at', [Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
            ->orderBy('created_at', 'DESC')->get();

        $manage_rider = view('pages.riders.rider-management')->with('all_rider_info', $rider_info);

        return view('dashboard')->with('main_content', $manage_rider);
    }


    public function change_rider_status(Request $request, $rider_id, $rider_status) {
        if ( $request->ajax() ) {
            DB::table('riders')->where('rider_id', $rider_id)->update( ['rider_status' => $rider_status ] );
            return response()->json(['success' => 'Rider Status changed successfully!', 'status' => 'success', 'rider_status' => $rider_status, 'rider_id'=>$rider_id ]);
        }
    }


    public function view_rider( Request $request, $rider_id )
    {
        if ( $request->ajax() ) {
            $view_rider = DB::table('riders')->where('rider_id', $rider_id )->first();
            $trip_count = DB::table('rider_trips')->where('rider_id', $rider_id)->COUNT();

            return response()->json( array( $view_rider, 'trip_count'=>$trip_count) );
        }
    }

    public function delete_rider( Request $request, $rider_id)
    {
        if ( $request->ajax() ) {
            DB::table('riders')->where('rider_id', $rider_id)->delete();

            $rider_item_ids = DB::table('purchase_order_items')->where('rider_id', $rider_id)->select('rider_item_id')->get();
            foreach($rider_item_ids as $rider_item_id){
                DB::table('purchase_order_items')->where('rider_item_id', $rider_item_id->rider_item_id)->delete();
            }
            return response()->json(['success' => 'Rider has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Rider', 'status' => 'failed']);
    }

    public function rider_favorite_places()
    {
        $favorite_place_info = DB::table('rider_favorite_places')
            ->leftjoin('riders', 'rider_favorite_places.rider_id', '=', 'riders.rider_id')
            ->select('rider_favorite_places.*', 'riders.mobile AS rider_mobile', 'riders.rider_name')
            ->orderBy('created_at', 'DESC')->get();
        $manage_place = view('pages.riders.rider-favourite-places')->with('all_favorite_place_info', $favorite_place_info);

        return view('dashboard')->with('main_content', $manage_place);
    }

    public function credit_cards()
    {
        $card_info = DB::table('credit_cards')
            ->leftjoin('riders', 'credit_cards.rider_id', '=', 'riders.rider_id')
            ->select('credit_cards.*', 'riders.mobile AS rider_mobile', 'riders.rider_name')
            ->orderBy('created_at', 'DESC')->get();
        $manage_card = view('pages.riders.credit-cards')->with('all_card_info', $card_info);

        return view('dashboard')->with('main_content', $manage_card);
    }
}
