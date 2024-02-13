<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use ZipArchive;


class GeneralInformationController extends Controller
{
    public function reload_employee(Request $request){
        if ( $request->ajax() ) {
            $all_employee = DB::table("employees")->orderBy('employee_name', 'ASC')->pluck('employee_id', 'employee_name');
            //$all_vendor = DB::table("landlords")->select(DB::raw("CONCAT(vendor_name,' - ', company_name) AS vendor_name, vendor_id"))->pluck("vendor_name", 'vendor_id');
            return response()->json( $all_employee );
        }
    }

    public function get_district(Request $request, $id){
        if ( $request->ajax() ) {
            $districts = DB::table("districts")->where("division_id", $id)->orderBy('district_name', 'ASC')->pluck("district_name","district_id");
            return json_encode( $districts );
        }
    }

    public function get_district_branch(Request $request, $id){
        if ( $request->ajax() ) {
            $districts = DB::table("districts")->where("division_id", $id)->orderBy('district_name', 'ASC')->pluck("district_name", "district_id");
            $branches = DB::table("branches")->where("division_id", $id)->orderBy('branch_name', 'ASC')->pluck("branch_name", "branch_id");
            //return json_encode( $districts );
            return response()->json( ['districts'=>$districts, 'branches'=>$branches] );
        }
    }

    public function get_all_district(Request $request){
        if ( $request->ajax() ) {
            $districts = DB::table("districts")->orderBy('district_name', 'ASC')->pluck("district_name", "district_id");
            return response()->json( $districts );
        }
    }

    public function get_district_filter(Request $request, $division_name){
        if ( $request->ajax() ) {
            $division_id = DB::table("divisions")->where("division_name", $division_name)->value("division_id");
            $districts = DB::table("districts")->where("division_id", $division_id)->orderBy('district_name', 'ASC')->pluck("district_name");
            $branch_name = DB::table("bma_branches")->where("division_id", $division_id)->orderBy('branch_name', 'ASC')->pluck("branch_name","branch_id");
            return response()->json( ['districts'=>$districts, 'branch_name'=>$branch_name] );
        }
    }

    public function in_word(Request $request){
        if ( $request->ajax() ) {
            $obj = new \TakaToWordConverter\WordConverter();
            $amount =  $obj->convert($request->amount);
            //$amount = taka_in_words( $request->amount );

            return response()->json( $amount );
        }
    }
}
