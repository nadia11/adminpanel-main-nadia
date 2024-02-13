<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class CommissionController extends Controller
{
    public function commission_settings()
    {
        $commission_info = DB::table('commissions')->get();
        $manage_commission = view('pages.accounts.commission-settings')->with('all_commission_info', $commission_info);

        return view('dashboard')->with('main_content', $manage_commission);
    }

    public function new_commission_save( Request $request)
    {
        //$validatedData = $request->validate([
        //    'title' => 'required|unique:commissionsts|max:255',
        //    'body' => 'required',
        //]);

        $data = array(
            'commission_name'    => $request->commission_name,
            'commission_percent' => $request->commission_percent,
            'note'               => $request->note,
            'created_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('commissions')->insert( $data );

        return redirect('/account/commission-settings')->with('success', 'Created New Commission Successfully!');
    }

    public function delete_commission( Request $request, $commission_id)
    {
        if ( $request->ajax() ) {
            DB::table('commissions')->where('commission_id', $commission_id)->delete();
            return response()->json(['success' => 'Commission has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the commission', 'status' => 'failed']);
    }

    public function edit_commission(Request $request, $commission_id )
    {
        if ( $request->ajax() ) {
            $commission_info = DB::table('commissions')->where('commission_id', $commission_id)->first();
            return response()->json( $commission_info );
        }
    }

    public function update_commission( Request $request )
    {
        $commission_id = $request->commission_id;

        $data = array(
            'commission_name'    => $request->commission_name,
            'commission_percent' => $request->commission_percent,
            'note'               => $request->note,
            'updated_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('commissions')->where('commission_id', $commission_id)->update( $data );

        return redirect('/account/commission-settings')->with('success', 'Update Commission Successfully!');
    }


    public function agent_commission_list()
    {
        $commission_info = DB::table('agent_commissions')
            ->leftjoin('drivers', 'agent_commissions.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('vehicles', 'agent_commissions.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select('agent_commissions.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number')
            ->orderBy('created_at', 'DESC')->get();

        $manage_earning = view('pages.accounts.agent-commissions')->with('all_commission_info', $commission_info);

        return view('dashboard')->with('main_content', $manage_earning);
    }

    public function agency_commission_list()
    {
        $commission_info = DB::table('agency_commissions')
            ->leftjoin('drivers', 'agency_commissions.driver_id', '=', 'drivers.driver_id')
            ->leftjoin('vehicles', 'agency_commissions.vehicle_id', '=', 'vehicles.vehicle_id')
            ->select('agency_commissions.*', 'drivers.mobile', 'drivers.driver_name', 'vehicles.vehicle_reg_number')
            ->orderBy('created_at', 'DESC')->get();

        $manage_earning = view('pages.accounts.agency-commissions')->with('all_commission_info', $commission_info);

        return view('dashboard')->with('main_content', $manage_earning);
    }

}
