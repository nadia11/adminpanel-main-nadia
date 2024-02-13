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


class PromoCodeController extends Controller
{
    public function promo_code_management()
    {
        $promo_code_info = DB::table('promo_codes')->orderBy('created_at', 'DESC')->get();
        $manage_promo_code = view('pages.promo-codes.promo-code-management')->with('all_promo_code_info', $promo_code_info);

        return view('dashboard')->with('main_content', $manage_promo_code);
    }

    public function new_promo_code_save( Request $request)
    {
        $data = array(
            'promo_name'       => $request->promo_name,
            'promo_code'       => $request->promo_code,
            'create_date'      => Carbon::createFromFormat('d/m/Y', $request->create_date )->format('Y-m-d H:i:s'),
            'expiry_date'      => Carbon::createFromFormat('d/m/Y', $request->expiry_date )->format('Y-m-d H:i:s'),
            'promo_amount'     => $request->promo_amount,
            'promo_code_count' => $request->promo_code_count,
            'promo_code_note'  => $request->promo_code_note,
            'promo_code_status'=> "active",
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('promo_codes')->insert( $data );
        return redirect('/promo-code/promo-code-management')->with('success', 'Created New Promo Code Successfully!');
    }


    public function edit_promo_code(Request $request, $promo_code_id )
    {
        if ( $request->ajax() ) {
            $promo_code_info = DB::table('promo_codes')->where('promo_code_id', $promo_code_id)->first();

            return response()->json( [$promo_code_info] );
        }
    }

    public function edit_promo_code_save( Request $request )
    {
        $promo_code_id = $request->promo_code_id;

        $data = array(
            'promo_name'       => $request->promo_name,
            'promo_code'       => $request->promo_code,
            'create_date'      => Carbon::createFromFormat('d/m/Y', $request->create_date )->format('Y-m-d H:i:s'),
            'expiry_date'      => Carbon::createFromFormat('d/m/Y', $request->expiry_date )->format('Y-m-d H:i:s'),
            'promo_amount'     => $request->promo_amount,
            'promo_code_count' => $request->promo_code_count,
            'promo_code_note'  => $request->promo_code_note,
            //'promo_code_status'=> "active",
            'updated_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('promo_codes')->where('promo_code_id', $promo_code_id)->update( $data );

        return redirect('/promo-code/promo-code-management')->with('success', 'Update Purchase Successfully!');
    }

    public function delete_promo_code( Request $request, $promo_code_id)
    {
        if ( $request->ajax() ) {
            DB::table('promo_codes')->where('promo_code_id', $promo_code_id)->delete();
            return response()->json(['success' => 'Promo Code has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Promo Code', 'status' => 'failed']);
    }

    public function view_promo_code( Request $request, $promo_code_id )
    {
        if ( $request->ajax() ) {
            $view_promo_code = DB::table('promo_codes')->where('promo_code_id', $promo_code_id )->first();
            return response()->json( array( $view_promo_code ) );
        }
    }

    public function change_promo_code_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('promo_codes')->where('promo_code_id', $request->promo_code_id)->update( ['promo_code_status' => $request->promo_code_status ] );
            return response()->json(['success' => 'Promo Code Status changed successfully!', 'status' => 'success', 'promo_code_status' => $request->promo_code_status, 'promo_code_id'=>$request->promo_code_id ]);
        }
    }
}
