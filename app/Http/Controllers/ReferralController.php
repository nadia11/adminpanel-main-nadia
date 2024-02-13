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


class ReferralController extends Controller
{
    public function referral_management()
    {
        $referral_info = DB::table('referrals')->orderBy('created_at', 'DESC')->get();
        $manage_referral = view('pages.referrals.referral-management')->with('all_referral_info', $referral_info);

        return view('dashboard')->with('main_content', $manage_referral);
    }


    public function new_referral_save( Request $request)
    {
        $data = array(
            'vehicle_id'       => $request->vehicle_id,
            'referral_per_km'      => $request->referral_per_km,
            'waiting_referral'     => $request->waiting_referral,
            'minimum_referral'     => $request->minimum_referral,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->referral_note,
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('referrals')->insert( $data );
        return redirect('/referral/referral-management')->with('success', 'Created New Referral Successfully!');
    }


    public function edit_referral(Request $request, $referral_id )
    {
        if ( $request->ajax() ) {
            $referral_info = DB::table('referrals')->where('referral_id', $referral_id)->first();

            return response()->json( [$referral_info] );
        }
    }

    public function edit_referral_save( Request $request )
    {
        $referral_id = $request->referral_id;

        $data = array(
            'vehicle_id'       => $request->vehicle_id,
            'referral_per_km'      => $request->referral_per_km,
            'waiting_referral'     => $request->waiting_referral,
            'minimum_referral'     => $request->minimum_referral,
            'minimum_distance' => $request->minimum_distance,
            'note'             => $request->referral_note,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('referrals')->where('referral_id', $referral_id)->update( $data );

        return redirect('/referral/referral-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_referral( Request $request, $referral_id)
    {
        if ( $request->ajax() ) {
            DB::table('referrals')->where('referral_id', $referral_id)->delete();
            return response()->json(['success' => 'Referral has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Referral', 'status' => 'failed']);
    }

    public function view_referral( Request $request, $referral_id )
    {
        if ( $request->ajax() ) {
            $view_referral = DB::table('referrals')->where('referral_id', $referral_id )->first();
            return response()->json( array( $view_referral ) );
        }
    }
}
