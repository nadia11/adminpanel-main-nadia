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


class DriverPaymentController extends Controller
{
    public function driver_payments()
    {
        $driver_info = DB::table('driver_payments')->orderBy('created_at', 'DESC')->get();
        $manage_driver = view('pages.drivers.driver-payment-management')->with('all_driver_info', $driver_info);

        return view('dashboard')->with('main_content', $manage_driver);
    }

    public function new_driver_save( Request $request)
    {
//        dd($request->all());
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'client_id'       => $request->client_id,
            'employee_id'     => $request->employee_id,
            'driver_number'       => $request->driver_number,
            'driver_date'         => Carbon::createFromFormat('d/m/Y', $request->driver_date )->format('Y-m-d H:i:s'),
            'delivery_date'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date )->format('Y-m-d H:i:s'),
            'project_name'    => $request->project_name,
            'description'     => $request->description,
            'job_status'      => $request->job_status,
            'bill_status'     => 'bill_pending',
            'driver_sub_total'    => $request->driver_sub_total,
            'driver_vat_percent'  => $request->driver_vat_percent,
            'driver_vat_amount'   => $request->driver_vat_amount,
            'driver_amount'       => $request->driver_amount,
            'advance_amount'  => $request->advance_amount,
            'balance_amount'  => $request->balance_amount,
            'driver_note'         => $request->driver_note,
            'created_by'      => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        if ($request->hasFile('driver_attachment')) {
            $upload_dir = storage_path('client-driver/' );
            $files = $request->file('driver_attachment');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $driver_attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $driver_attachment );

            $data['driver_attachment'] = $driver_attachment;
        }
        DB::table('driver_payments')->insert( $data );

        return redirect('/driver/driver-management')->with('success', 'Created New Purchase Successfully!');
    }

    public function edit_driver(Request $request, $driver_id )
    {
        if ( $request->ajax() ) {
            $driver_info = DB::table('driver_payments')->where('driver_id', $driver_id)->first();
            $employee = DB::table('employees')->where('employee_id', $driver_info->employee_id)->select("designation_id",'employee_name', 'employee_mobile')->first();
            $designation_name = DB::table('designations')->where('designation_id', $employee->designation_id)->value('designation_name');
            $client_address = DB::table('clients')->where('client_id', $driver_info->client_id)->value('client_address');
            $driver_items = DB::table('purchase_order_items')->where('driver_id', $driver_id)->get();
            $in_word = taka_in_words(intval(  $driver_info->balance_amount, 0) );

            return response()->json( [$driver_info, 'driver_items'=>$driver_items, 'in_word'=>$in_word, 'employee'=>$employee, 'designation_name'=>$designation_name, 'client_address'=>$client_address] );
        }
    }

    public function update_driver( Request $request )
    {
        $driver_id = $request->driver_id;

        $data = array(
            'client_id'       => $request->client_id,
            'employee_id'     => $request->employee_id,
            'driver_number'       => $request->driver_number,
            'driver_date'         => Carbon::createFromFormat('d/m/Y', $request->driver_date )->format('Y-m-d H:i:s'),
            'delivery_date'   => Carbon::createFromFormat('d/m/Y', $request->delivery_date )->format('Y-m-d H:i:s'),
            'project_name'    => $request->project_name,
            'description'     => $request->description,
            'job_status'      => $request->job_status,
            'bill_status'     => 'bill_pending',
            'driver_sub_total'    => $request->driver_sub_total,
            'driver_vat_percent'  => $request->driver_vat_percent,
            'driver_vat_amount'   => $request->driver_vat_amount,
            'driver_amount'       => $request->driver_amount,
            'advance_amount'  => $request->advance_amount,
            'balance_amount'  => $request->balance_amount,
            'driver_note'         => $request->driver_note,
            'created_by'      => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );


        if ($request->hasFile('driver_attachment')) {
            $upload_dir = storage_path('client-driver/' );
            $files = $request->file('driver_attachment');

            $file_name_WithExt = $files->getClientOriginalName();
            $extension = strtolower( $files->getClientOriginalExtension() );
            $driver_attachment = Str::slug( pathinfo($file_name_WithExt, PATHINFO_FILENAME) ) . ".".$extension;
            $success = $files->move( $upload_dir, $driver_attachment );

            if( $request->driver_attachment_prev ){
                //Storage::disk('local')->delete('client-driver/' . $request->driver_attachment_prev);.
                if(file_exists($upload_dir . $request->driver_attachment_prev)) {
                    unlink( $upload_dir . $request->driver_attachment_prev ); //delete previous image from upload folder
                }
            }
            $data['driver_attachment'] = $driver_attachment;
        }else{
            $data['driver_attachment'] = $request->driver_attachment_prev;
        }
        DB::table('driver_payments')->where('driver_id', $driver_id)->update( $data );

        return redirect('/driver/driver-management')->with('success', 'Update Purchase Successfully!');
    }


    public function delete_driver( Request $request, $driver_id)
    {
        if ( $request->ajax() ) {
            DB::table('driver_payments')->where('driver_id', $driver_id)->delete();

            $driver_item_ids = DB::table('purchase_order_items')->where('driver_id', $driver_id)->select('driver_item_id')->get();
            foreach($driver_item_ids as $driver_item_id){
                DB::table('purchase_order_items')->where('driver_item_id', $driver_item_id->driver_item_id)->delete();
            }
            return response()->json(['success' => 'driver has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the driver', 'status' => 'failed']);
    }

    public function change_driver_status(Request $request, $driver_id, $driver_status) {
        if ( $request->ajax() ) {
            DB::table('driver_payments')->where('driver_id', $driver_id)->update( ['driver_status' => $driver_status ] );
            return response()->json(['success' => 'driver Status changed successfully!', 'status' => 'success', 'driver_status' => $driver_status, 'driver_id'=>$driver_id ]);
        }
    }

//    public function check_driver(Request $request, $driver_number)
//    {
//        if ( $request->ajax() ) {
//            $driver_number = DB::table('driver_payments')->where('driver_number', $driver_number)->exists();
//            return response()->json( $driver_number );
//        }
//    }

    public function view_driver( Request $request, $driver_id )
    {
        if ( $request->ajax() ) {
            $view_driver = DB::table('driver_payments')->where('driver_id', $driver_id )->first();
            $client_name = DB::table('clients')->where('client_id', $view_driver->client_id )->value('client_name');
            $employee_data = DB::table('employees')->select('employee_id','employee_name', 'designation_id', 'employee_mobile')->where('employee_id', $view_driver->employee_id )->first();
            $designation_name = DB::table('designations')->where('designation_id', $employee_data->designation_id )->value('designation_name');

            $driver_items = DB::table('purchase_order_items')->where('driver_id', $driver_id)->get();
            $billing_info = DB::table('client_bills')->where('driver_id', $driver_id )->get();
            //$total_bill = DB::table('client_bills')->where('driver_id', $driver_id)->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first();
            $vendor_bills = DB::table('vendor_bills')->where('driver_id', $driver_id )->get();

            return response()->json( array( $view_driver, 'driver_items' => $driver_items, 'client_name'=>$client_name, 'employee_data'=>$employee_data, 'designation_name'=>$designation_name, 'billing_info'=>$billing_info, 'vendor_bills'=>$vendor_bills) );
        }
    }
}
