<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PayrollController extends Controller
{

    public function employee_ledger() {

        $employee_ledger_infos = DB::table('employee_ledgers')
            ->join('account_heads', 'employee_ledgers.account_head_id', '=', 'account_heads.account_head_id')
            ->join('employees', 'employee_ledgers.employee_id', '=', 'employees.employee_id')
            ->select('employee_ledgers.*', 'employees.employee_name', 'account_heads.account_head_name')
            ->get();

        $manage_cashbook_entry = view('pages.payrolls.employee-ledger')->with('employee_ledger_infos', $employee_ledger_infos);

        return view('dashboard')->with('main_content', $manage_cashbook_entry);
    }

    public function employee_list_with_salary()
    {
        $salary_sheet_info = DB::table('employee_list_with_salaries')
        ->leftjoin('employees', 'employees.employee_id', '=', 'employee_list_with_salaries.employee_id')
        ->select('employee_list_with_salaries.*', 'employees.employee_name', 'employees.designation_id')
        ->get();

        $total_value = DB::table('employee_list_with_salaries')->select(DB::raw('SUM(basic_salary) as total_salary, SUM(house_rent) as total_house_rent, SUM(medical_allowance) as total_medical_allowance'))->first();
        //$total = DB::table('payrolls')->select(DB::raw('sum(quantity*price*(1-discount/100)) as  total'))->first()->total;
        $manage_salary_sheet = view('pages.payrolls.employee-list-with-salary')->with('salary_sheet_info', $salary_sheet_info)->with('total_value', $total_value);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
    }

    public function add_employee_to_salary_sheet_save( Request $request)
    {
        //$input = $request->all();

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'employee_id'       => $request->employee_id,
            'basic_salary'      => $request->basic_salary,
            'house_rent'        => $request->house_rent,
            'medical_allowance' => $request->medical_allowance,
            'user_id'           => Auth::id(),
            'created_at'        => date('Y-m-d H:i:s'),
        );
        DB::table('employee_list_with_salaries')->insert( $data );

        //Session::put('success', 'Created New Purchases Successfully!');
        //return Redirect::to('/new-payroll');
        return redirect('/payroll/employee-list-with-salary')->with('success', 'Created New Purchase Successfully!');
    }

//    public function edit_payroll(Request $request, $payroll_id )
//    {
//        if ( $request->ajax() ) {
//            $payroll_info = DB::table('purchase_orders')->where('payroll_id', $payroll_id)
//                ->leftjoin('districts', 'payroll.district_id', '=', 'districts.district_id')
//                ->select('payroll.*', 'districts.district_id', 'districts.district_name')
//                ->first();
//            return respayrollnse()->json( $payroll_info );
//        }
//    }

//    public function update_payroll( Request $request )
//    {
//        $payroll_id = $request->payroll_id;
//
//
//        DB::table('purchase_orders')->where('payroll_id', $payroll_id)->update( $data );
//
//        return redirect('/payroll/payroll-management')->with('success', 'Update Purchase Successfully!');
//    }


//    public function delete_payroll( Request $request, $payroll_id)
//    {
//        if ( $request->ajax() ) {
//            DB::table('purchase_orders')->where('payroll_id', $payroll_id)->delete();
//
//            return response()->json(['success' => 'PO has been deleted successfully!', 'status' => 'success']);
//        }
//        return response(['error' => 'Failed deleting the product', 'status' => 'failed']);
//    }

    public function make_salary_sheet($month_number)
    {
        $salary_sheet_info = DB::table('employee_list_with_salaries')
        ->leftjoin('employees', 'employees.employee_id', '=', 'employee_list_with_salaries.employee_id')
        ->select('employee_list_with_salaries.*', 'employees.employee_name', 'employees.designation_id')
        ->get();

        $month_name_array = array( 1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');
        $manage_salary_sheet = view('pages.payrolls.make-salary-sheet')->with('salary_sheet_info', $salary_sheet_info)->with('month_name', $month_name_array[$month_number])->with('month_number', $month_number);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
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

//    public function payroll_status(Request $request, $payroll_id, $payroll_status) {
//        if ( $request->ajax() ) {
//
//            DB::table('purchase_orders')->where('payroll_id', $payroll_id)->update( ['payroll_status' => $payroll_status ] );
//
//            return response()->json(['success' => 'PO Status changed successfully!', 'status' => 'success', 'payroll_status' => $payroll_status ]);
//        }
//    }


//    public function view_payroll( Request $request, $payroll_id )
//    {
//        if ( $request->ajax() ) {
//            $view_payroll = DB::table('purchase_orders')->where('payroll_id', $payroll_id )->first();
//            $payroll_items = DB::table('purchase_order_items')->where('payroll_id', $payroll_id)->get();
//            $client_name = DB::table('clients')->where('client_id', $view_payroll->client_id )->value('client_name');
//
//            return response()->json( array( $view_payroll, 'payroll_items' => $payroll_items, 'client_name'=>$client_name) );
//        }
//    }

    public function salary_payment_summery()
    {
        $salary_sheet_info = DB::table('salary_sheets')
            ->leftjoin('employees', 'employees.employee_id', '=', 'salary_sheets.employee_id')
            ->select('salary_sheets.*', 'employees.employee_name', 'employees.designation_id')
            ->get();

        $manage_salary_sheet = view('pages.payrolls.report-salary-payment-summery')->with('salary_sheet_info', $salary_sheet_info);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
    }

    public function detail_salary_history()
    {
        $salary_sheet_info = DB::table('salary_sheets')
            ->leftjoin('employees', 'employees.employee_id', '=', 'salary_sheets.employee_id')
            ->select('salary_sheets.*', 'employees.employee_name', 'employees.designation_id')
            ->get();

        $manage_salary_sheet = view('pages.payrolls.report-detail-history')->with('salary_sheet_info', $salary_sheet_info);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
    }

    public function employee_wise_history()
    {
        $salary_sheet_info = DB::table('salary_sheets')
            ->leftjoin('employees', 'employees.employee_id', '=', 'salary_sheets.employee_id')
            ->select('salary_sheets.*', 'employees.employee_name', 'employees.designation_id')
            ->get();

        $manage_salary_sheet = view('pages.payrolls.report-employee-wise-history')->with('salary_sheet_info', $salary_sheet_info);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
    }

    public function month_wise_history()
    {
        $salary_sheet_info = DB::table('salary_sheets')
            ->leftjoin('employees', 'employees.employee_id', '=', 'salary_sheets.employee_id')
            ->select('salary_sheets.*', 'employees.employee_name', 'employees.designation_id')
            ->get();

        $manage_salary_sheet = view('pages.payrolls.report-month-wise-history')->with('salary_sheet_info', $salary_sheet_info);

        return view('dashboard')->with('main_content', $manage_salary_sheet);
    }
}
