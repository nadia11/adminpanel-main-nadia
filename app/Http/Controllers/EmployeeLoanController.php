<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;


class EmployeeLoanController extends Controller
{

    public function loan_management()
    {
        $loan_info = DB::table('employee_loans')->get();
        $manage_loan = view('pages.employees.loan-management')->with('all_loan_info', $loan_info);

        return view('dashboard')->with('main_content', $manage_loan);
    }

    public function new_loan_save( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:loansts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'loan_opening_date' => Carbon::createFromFormat('d/m/Y', $request->loan_opening_date )->format('Y-m-d H:i:s'),
            'loan_type'         => $request->loan_type,
            'loan_name'         => $request->loan_name,
            'loan_uom'          => $request->loan_uom,
            'loan_rate'         => $request->loan_rate,
            'loan_qty'          => $request->loan_qty,
            'loan_total_amount' => $request->loan_total_amount,
            'loan_description'  => $request->loan_description,
            'created_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('employee_loans')->insert( $data );

        //Session::put('success', 'Created New Purchases Successfully!');
        //return Redirect::to('/new-loan');
        return redirect('/account/loan-list')->with('success', 'Created New Purchase Successfully!');
    }


    public function delete_loan( Request $request, $loan_id)
    {
        if ( $request->ajax() ) {
            DB::table('employee_loans')->where('loan_id', $loan_id)->delete();
            return response()->json(['success' => 'Loan has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the loan', 'status' => 'failed']);
    }

    public function edit_loan(Request $request, $loan_id )
    {
        if ( $request->ajax() ) {
            $loan_info = DB::table('employee_loans')->where('loan_id', $loan_id)->first();
            return response()->json( $loan_info );
        }
    }

    public function update_loan( Request $request )
    {
        $loan_id = $request->loan_id;

        $data = array(
            'loan_opening_date' => Carbon::createFromFormat('d/m/Y', $request->loan_opening_date )->format('Y-m-d H:i:s'),
            'loan_type'         => $request->loan_type,
            'loan_name'         => $request->loan_name,
            'loan_uom'          => $request->loan_uom,
            'loan_rate'         => $request->loan_rate,
            'loan_qty'          => $request->loan_qty,
            'loan_total_amount' => $request->loan_total_amount,
            'loan_description'  => $request->loan_description,
            'updated_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('employee_loans')->where('loan_id', $loan_id)->update( $data );

        return redirect('/account/loan-list')->with('success', 'Update Loan Successfully!');
    }


    public function get_employee_data(Request $request)
    {
        if ( $request->ajax() ) {
            $employee_info = DB::table("employees")->where("employee_id", $request->employee_id)->first();
            $department_name = DB::table("departments")->where("department_id", $employee_info->department_id)->value('department_name');
            $designation_name = DB::table("designations")->where("designation_id", $employee_info->designation_id)->value('designation_name');

            return response()->json( [$employee_info, 'department_name'=>$department_name, 'designation_name'=>$designation_name] );
        }
    }
}
