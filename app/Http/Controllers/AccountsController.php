<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class AccountsController extends Controller
{

    public function cashbook()
    {
        $cashbook_infos = DB::table('cashbook_entries')
            ->leftJoin('account_heads', 'cashbook_entries.account_head_id', '=', 'account_heads.account_head_id')
            ->select('cashbook_entries.*', 'account_heads.account_head_name')
            ->get();
        $manage_cashbook_entry = view('pages.accounts.cashbook')->with('cashbook_infos', $cashbook_infos);

        return view('dashboard')->with('main_content', $manage_cashbook_entry);
    }

    public function cashbook_entry()
    {
        $cashbook_infos = DB::table('cashbook_entries')
            ->leftJoin('account_heads', 'cashbook_entries.account_head_id', '=', 'account_heads.account_head_id')
            ->select('cashbook_entries.*', 'account_heads.account_head_name')
            ->whereDate('cashbook_entries.created_at', date('Y-m-d'))
            ->get();
        $manage_cashbook_entry = view('pages.accounts.cashbook-entry')->with('cashbook_infos', $cashbook_infos);

        return view('dashboard')->with('main_content', $manage_cashbook_entry);
    }

    public function daily_expense_save( Request $request)
    {
        //$input = $request->all();
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        if ( $request->ajax() ) {
            $data = array(
                'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
                //'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->setTimezone('Asia/Dhaka')->format('Y-m-d H:i:s'),
                'voucher_number'  => $request->voucher_number,
                'account_head_id' => $request->account_head_id,
                'party_id'        => $request->party_id,
                'party_type'      => $request->party_type,
                'party_name'      => $request->party_name,
                'description'     => $request->description,
                'debit'           => $request->paid_amount,
                //'credit'          => '',
                'payment_method'  => $request->payment_method,
                'expense_for'     => $request->expense_for,
                'entry_type'      => "daily-expense",
                'user_id'         => Auth::id(),
                'created_at'      => date('Y-m-d H:i:s'),
            );
            $insert_id = DB::table('cashbook_entries')->insertGetId( $data );

            $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
            $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
            $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
            $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

            return response()->json( array( $data, 'success' => 'Daily Expense save Successfully!', 'status' => 'success', 'insert_id' => $insert_id, 'account_head_name' => $account_head_name, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
        }
        return response(['error' => 'Failed to save Daily Expense', 'status' => 'failed']);
    }

    public function edit_daily_expense(Request $request, $cashbook_id ) {
        if ( $request->ajax() ) {
            $bank_info = DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->first();

            return response()->json( [$bank_info, 'row_index' => $request->row_index] );
        }
    }

    public function update_daily_expense( Request $request ){

        $cashbook_id = $request->cashbook_id;
        if ( $request->ajax() ) {
            $data = array(
                //'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
                'voucher_number'  => $request->voucher_number,
                'account_head_id' => $request->account_head_id,
                'party_id'        => $request->party_id,
                'party_type'      => $request->party_type,
                'party_name'      => $request->party_name,
                'description'     => $request->description,
                'debit'           => $request->paid_amount,
                //'credit'          => '',
                'payment_method'  => $request->payment_method,
                'entry_type'      => "daily-expense",
                'user_id'         => Auth::id(),
                'updated_at'      => date('Y-m-d H:i:s'),
            );
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->update( $data );

            $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
            $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
            $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
            $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

            return response()->json( array( $data, 'success' => 'Daily Expense Update Successfully!', 'status' => 'success', 'cashbook_id' => $cashbook_id, 'account_head_name' => $account_head_name, 'row_index' => $request->row_index, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
        }
        return response(['message' => 'Failed to save Daily Expense']);
    }

    public function delete_daily_expense( Request $request, $cashbook_id) {
        if ( $request->ajax() ) {
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->delete();
            return response()->json(['success' => 'Entry has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Entry', 'status' => 'failed']);
    }



    /***********************************
     * Cash Receive
     * *********/
    public function cash_receive_save( Request $request)
    {
        //$input = $request->all();
        //dd($request->bank_account_id);
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        if ( $request->ajax() ) {
            $data = array(
                'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date )->format('Y-m-d H:i:s'),
                'credit'          => $request->cash_receive_amount,
                'description'     => $request->description,
                'account_head_id' => $request->account_head_id,
                'party_name'      => $request->party_name,
                'entry_type'      => "cash-receive",
                'created_at'      => date('Y-m-d H:i:s'),
            );
            $insert_id = DB::table('cashbook_entries')->insertGetId( $data );

            $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
            $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
            $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
            $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');


            /*****************************************/
            if($request->bank_account_id) {
                $bank_data = array(
                    'withdraw_date' => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date)->format('Y-m-d H:i:s'),
                    //'party_type'    => 'Self',
                    //'party_id'      => $request->party_id,
                    //'party_name'    => settings('company_name'),
                    'bank_account_id' => $request->bank_account_id,
                    'account_number' => $request->account_number,
                    'bank_name' => $request->bank_name,
                    'branch' => $request->branch,
                    'cheque_book_id' => $request->cheque_book_id,
                    //'cheque_leaf_id'=> $request->cheque_leaf_id,
                    'cheque_number' => $request->cheque_number,
                    //'cheque_type'   => 'Cash Cheque',
                    'cheque_date' => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date)->format('Y-m-d H:i:s'),
                    'cheque_amount' => $request->cash_receive_amount,
                    'withdraw_desc' => $request->description,
                    'withdraw_status' => 'Pending',
                    'user_id' => Auth::id(),
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('cash_withdraws')->insert($bank_data);

                //Update cheque leaf, because leaf is made with cheque book created.
                $leaf_data = array(
                    'leaf_issue_date' => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date)->format('Y-m-d H:i:s'),
                    'cheque_leaf_amount' => $request->cash_receive_amount,
                    'voucher_id' => $request->voucher_id,
                    //'party_id'           => $request->party_id,
                    'party_type' => 'Self',
                    'party_name' => settings('company_name'),
                    'cheque_leaf_status' => "Used",
                    'user_id' => Auth::id(),
                );
                DB::table('bank_cheque_leafs')->where('cheque_number', $request->cheque_number)->update($leaf_data);

                $trx_data = array(
                    'trx_date' => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date)->format('Y-m-d H:i:s'),
                    'trx_type' => 'cash_withdraw',
                    'party_type' => 'Self',
                    //'party_id'         => $request->party_id,
                    'party_name' => settings('company_name'),
                    'voucher_id' => $request->voucher_id,
                    'bank_account_id' => $request->bank_account_id,
                    'account_number' => $request->account_number,
                    'cheque_number' => $request->cheque_number,
                    'cheque_date' => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date)->format('Y-m-d H:i:s'),
                    //'bank_date'      => '',
                    'cheque_type' => 'Cash Cheque',
                    'debit' => $request->cash_receive_amount,
                    'created_at' => date('Y-m-d H:i:s'),
                );
                DB::table('bank_transactions')->insert($trx_data);
            }

            return response()->json( array( $data, 'success' => 'Cash Receive save Successfully!', 'status' => 'success', 'insert_id' => $insert_id, 'account_head_name' => $account_head_name, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
        }
        return response(['error' => 'Failed to save Cash Receive', 'status' => 'failed']);
    }

    public function edit_cash_receive(Request $request, $cashbook_id ) {
        if ( $request->ajax() ) {
            $bank_info = DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->first();

            return response()->json( [$bank_info, 'row_index' => $request->row_index] );
        }
    }

    public function update_cash_receive( Request $request)
    {
        //$input = $request->all();
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);
        $cashbook_id = $request->cashbook_id;

        if ( $request->ajax() ) {
            $data = array(
                //'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->cash_receive_date )->format('Y-m-d H:i:s'),
                'credit'          => $request->cash_receive_amount,
                'description'     => $request->description,
                'account_head_id' => $request->account_head_id,
                'party_name'      => $request->party_name,
                'entry_type'      => "cash-receive",
                'updated_at'      => date('Y-m-d H:i:s'),
            );
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->update( $data );

            $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
            $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
            $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
            $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

            return response()->json( array( $data, 'success' => 'Daily Expense Update Successfully!', 'status' => 'success', 'cashbook_id' => $cashbook_id, 'account_head_name' => $account_head_name, 'row_index' => $request->row_index, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
        }
        return response(['error' => 'Failed to Update Cash Receive', 'status' => 'failed']);
    }

    public function get_cheque_book_data_to_cash_receive(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->first();

            //for loop cheque book dropdown
            $cheque_book_data = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->where("cheque_book_status", '=', 'open')->pluck("cheque_book_no", 'cheque_book_id');

            return response()->json( [$account_info, 'cheque_book'=>$cheque_book_data] );
        }
    }

    public function get_cheque_leaf_to_cash_receive(Request $request)
    {
        if ( $request->ajax() ) {
            $check_leafs = DB::table("bank_cheque_leafs")->where("cheque_book_id", $request->id)->where("cheque_leaf_status", '=', 'Unused')->pluck('cheque_number', 'cheque_leaf_id');
            return response()->json( $check_leafs );
        }
    }

    public function get_party_list(Request $request)
    {
        if ( $request->ajax() ) {
            $client_list = '';
            $queries = DB::table('clients')->select('client_name')->get();
            foreach($queries as $query){ $client_list .= '<option value="'. $query->client_name .'">'; }


//            switch ($account_head){
//                case 'Cash Withdraw' :
//                    $queries = DB::table('bank_name_lists')->select('bank_name')->get();
//                    foreach($queries as $query){ $party_list .= '<option value="'. $query->bank_name .'">'; }
//                    break;
//
//                default :
//                    $queries = DB::table('clients')->select('client_name')->get();
//                    foreach($queries as $query){ $party_list .= '<option value="'. $query->client_name .'">'; }
//                    break;
//            }
            return response()->json(['client_list'=>$client_list, 'account_head'=>$request->account_head]);
        }
    }


    /***********************************
     * Employee Payment
     * *********/
    public function employee_payment_save( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $employee_name = DB::table('employees')->where("employee_id", $request->employee_id)->value('employee_name');

        $data = array(
            'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'voucher_number'  => $request->voucher_number,
            'account_head_id' => $request->account_head_id,
            'party_id'        => $request->employee_id,
            'party_type'      => 'employee',
            'party_name'      => $employee_name,
            'description'     => $request->description,
            'payment_method'  => $request->payment_method,
            'entry_type'      => "employee-payment",
            'debit'           => $request->paid_amount,
            'credit'          => '0.00',
            'user_id'         => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        $insert_id = DB::table('cashbook_entries')->insertGetId( $data );

        $employee_data = array(
            'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'voucher_number'  => $request->voucher_number,
            'payment_method'  => $request->payment_method,
            'account_head_id' => $request->account_head_id,
            'employee_id'     => $request->employee_id,
            'month_name'      => Carbon::createFromFormat('d/m/Y', date('d') ."/". $request->month_name ."/". date('Y') )->format('Y-m-d H:i:s'),
            'amount'           => $request->paid_amount,
            'description'     => $request->description,
            'cashbook_id'     => $insert_id,
            'user_id'         => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('employee_ledgers')->insert( $employee_data );

        $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
        $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
        $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
        $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

        return response()->json( array( $data, 'success' => 'Employee Payment save Successfully!', 'status' => 'success', 'insert_id' => $insert_id, 'account_head_name' => $account_head_name, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
    }

    public function edit_employee_payment(Request $request, $cashbook_id ) {
        if ( $request->ajax() ) {
            $bank_info = DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->first();
            $month_name = DB::table('employee_ledgers')->where('cashbook_id', $bank_info->cashbook_id)->value('month_name');

            return response()->json( [$bank_info, 'row_index' => $request->row_index, 'month_name'=>$month_name] );
        }
    }

    public function update_employee_payment( Request $request)
    {
        $cashbook_id = $request->cashbook_id;
        $employee_name = DB::table('employees')->where("employee_id", $request->employee_id)->value('employee_name');

        if ( $request->ajax() ) {
            $data = array(
                //'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
                'voucher_number'  => $request->voucher_number,
                'account_head_id' => $request->account_head_id,
                'party_id'        => $request->employee_id,
                'party_type'      => 'employee',
                'party_name'      => $employee_name,
                'description'     => $request->description,
                'payment_method'  => $request->payment_method,
                'entry_type'      => "employee-payment",
                'debit'           => $request->paid_amount,
                'credit'          => '0.00',
                'user_id'         => Auth::id(),
                'created_at'      => date('Y-m-d H:i:s'),
            );
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->update( $data );

            $employee_data = array(
                'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
                'voucher_number'  => $request->voucher_number,
                'payment_method'  => $request->payment_method,
                'account_head_id' => $request->account_head_id,
                'employee_id'     => $request->employee_id,
                'month_name'      => Carbon::createFromFormat('d/m/Y', date('d') ."/". $request->month_name ."/". date('Y') )->format('Y-m-d H:i:s'),
                'amount'           => $request->paid_amount,
                'description'     => $request->description,
                'cashbook_id'     => $cashbook_id,
                'user_id'         => Auth::id(),
                'created_at'      => date('Y-m-d H:i:s'),
            );
            DB::table('employee_ledgers')->where('cashbook_id', $cashbook_id)->update( $employee_data );

            $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
            $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
            $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
            $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

            return response()->json( array( $data, 'success' => 'Employee Payment Update Successfully!', 'status' => 'success', 'cashbook_id' => $cashbook_id, 'account_head_name' => $account_head_name, 'row_index' => $request->row_index, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
        }
        return response(['error' => 'Failed to save Cash Receive', 'status' => 'failed']);
    }

    public function delete_employee_payment( Request $request, $cashbook_id) {
        if ( $request->ajax() ) {
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->delete();
            DB::table('employee_ledgers')->where('cashbook_id', $cashbook_id)->delete();
            return response()->json(['success' => 'Entry has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Entry', 'status' => 'failed']);
    }


    /***********************************
     * Vendor Payment
     * *********/

    public function vendor_payment_save( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $vendor_name = DB::table('vendors')->where("vendor_id", $request->vendor_id)->value('vendor_name');

        $data = array(
            'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'voucher_number'  => $request->voucher_number,
            'account_head_id' => $request->account_head_id,
            'party_id'        => $request->vendor_id,
            'client_id'          => $request->client_id,
            'party_type'      => 'vendor',
            'party_name'      => $vendor_name,
            'description'     => $request->description,
            'payment_method'  => $request->payment_method,
            'debit'           => $request->paid_amount,
            'entry_type'      => "vendor-payment",
            'credit'          => '0.00',
            'user_id'         => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        $insert_id = DB::table('cashbook_entries')->insertGetId( $data );


        $vendor_data = array(
            'entry_date'         => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'payment_method'     => $request->payment_method,
            'voucher_number'     => $request->voucher_number,
            'account_head_id'    => $request->account_head_id,
            'bill_no'            => $request->bill_no,
            'billing_amount'     => $request->billing_amount,
            'received_amount'    => $request->paid_amount,
            'vendor_id'        => $request->vendor_id,
            'client_id'          => $request->client_id,
            'po_id'              => $request->po_id,
            'project_name'       => $request->project_name,
            //'bill_status'        => $request->bill_status,
            //'work_received_from' => $request->work_received_from,
            'description'        => $request->description,
            'cashbook_id'        => $insert_id,
            'user_id'            => Auth::id(),
            'created_at'         => date('Y-m-d H:i:s'),
        );
        if($request->bill_date) { $vendor_data['bill_date'] = Carbon::createFromFormat('d/m/Y', $request->bill_date)->format('Y-m-d H:i:s'); }
        DB::table('vendor_ledgers')->insert( $vendor_data );


        $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
        $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
        $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
        $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

        return response()->json( array( $data, 'success' => 'Vendor Payment save Successfully!', 'status' => 'success', 'insert_id' => $insert_id, 'account_head_name' => $account_head_name, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
    }

    public function edit_vendor_payment(Request $request, $cashbook_id ) {
        if ( $request->ajax() ) {
            $cashbook_info = DB::table('vendor_ledgers')->where('cashbook_id', $cashbook_id)->first();
            $project_name = DB::table('purchase_orders')->where('po_id', $cashbook_info->po_id)->value('project_name');
            $client_name = DB::table('clients')->where('client_id', $cashbook_info->client_id)->value('client_name');

            return response()->json( [$cashbook_info, 'row_index' => $request->row_index, 'project_name'=>$project_name, 'client_name'=>$client_name] );
        }
    }

    public function update_vendor_payment( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $cashbook_id = $request->cashbook_id;
        $vendor_name = DB::table('vendors')->where("vendor_id", $request->vendor_id)->value('vendor_name');

        $data = array(
            //'entry_date'      => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'voucher_number'  => $request->voucher_number,
            'account_head_id' => $request->account_head_id,
            'party_id'        => $request->vendor_id,
            'client_id'       => $request->client_id,
            'party_type'      => 'vendor',
            'party_name'      => $vendor_name,
            'description'     => $request->description,
            'payment_method'  => $request->payment_method,
            'debit'           => $request->paid_amount,
            'entry_type'      => "vendor-payment",
            'credit'          => '0.00',
            'user_id'         => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->update( $data );

        $vendor_data = array(
            'entry_date'         => Carbon::createFromFormat('d/m/Y', $request->entry_date )->format('Y-m-d H:i:s'),
            'payment_method'     => $request->payment_method,
            'voucher_number'     => $request->voucher_number,
            'account_head_id'    => $request->account_head_id,
            'bill_no'            => $request->bill_no,
            'bill_date'          => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
            'billing_amount'     => $request->billing_amount,
            'received_amount'    => $request->paid_amount,
            'vendor_id'          => $request->vendor_id,
            'client_id'          => $request->client_id,
            'po_id'              => $request->po_id,
            'project_name'       => $request->project_name,
            'bill_status'        => $request->bill_status,
            'work_received_from' => $request->work_received_from,
            'description'        => $request->description,
            'cashbook_id'        => $cashbook_id,
            'user_id'            => Auth::id(),
            'created_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('vendor_ledgers')->where('cashbook_id', $cashbook_id)->update( $vendor_data );

        $balance_query = DB::table('cashbook_entries')->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first(); $total_balance = $balance_query->credit - $balance_query->debit;
        $today_debit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('debit');
        $today_credit = DB::table('cashbook_entries')->whereDate('cashbook_entries.created_at', date('Y-m-d'))->sum('credit');
        $account_head_name = DB::table('account_heads')->where('account_head_id', $request->account_head_id)->value('account_head_name');

        return response()->json( array( $data, 'success' => 'Vendor Payment Update Successfully!', 'status' => 'success', 'cashbook_id' => $cashbook_id, 'account_head_name' => $account_head_name, 'row_index' => $request->row_index, 'total_balance'=> taka_format('', $total_balance ), 'today_debit'=> taka_format('', $today_debit ), 'today_credit'=> taka_format('', $today_credit ) ));
    }

    public function get_po_data(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table("purchase_orders")->where("po_id", $request->po_id)->select('client_id', 'project_name')->first();
            $client_name = DB::table("clients")->where("client_id", $account_info->client_id)->value('client_name');

            return response()->json( [$account_info, 'client_name'=>$client_name] );
        }
    }

    public function get_vendor_data(Request $request)
    {
        if ( $request->ajax() ) {
            $vendor_bill_amount = DB::table("vendor_bills")->where("vendor_id", $request->vendor_id)->sum('billing_amount');
            $vendor_received_amount = DB::table("vendor_ledgers")->where("vendor_id", $request->vendor_id)->sum('received_amount');
            $vendor_bill_balance = $vendor_bill_amount - $vendor_received_amount;

            //for loop cheque book dropdown
            $vendor_bill_list = DB::table("vendor_bills")->where("vendor_id", $request->vendor_id)->where("bill_status", '=', 'open')->pluck("bill_no", 'vendor_bill_id');
            $po_data = DB::table("vendor_wo")->leftJoin('purchase_orders', 'vendor_wo.po_id', '=', 'purchase_orders.po_id')->where("vendor_id", $request->vendor_id)->select(DB::raw("CONCAT(purchase_orders.po_number,' - ', purchase_orders.project_name) AS po_number, purchase_orders.po_id"))->pluck('po_number', 'po_id');

            return response()->json( ['vendor_bill_list'=>$vendor_bill_list, 'vendor_bill_balance'=>$vendor_bill_balance, 'po_data'=>$po_data] );
        }
    }

    public function get_po_from_bill(Request $request)
    {
        if ( $request->ajax() ) {
            $bill_data = DB::table("vendor_bills")->where("vendor_bill_id", $request->bill_no)->select('po_id', 'bill_date')->first();
            $po_data = DB::table("purchase_orders")->where("po_id", $bill_data->po_id)->select('po_id', 'po_number','client_id', 'project_name')->first();
            $client_name = DB::table("clients")->where("client_id", $po_data->client_id)->value('client_name');

            return response()->json( ['po_data'=>$po_data, 'client_name'=>$client_name, 'bill_date'=>$bill_data->bill_date, 'client_id'=>$po_data->client_id] );
        }
    }


//    public function view_cashbook_entry( Request $request, $cashbook_id )
//    {
//        if ( $request->ajax() ) {
//            $view_cashbook_entries = DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id )->first();
//            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $view_cashbook_entries->bank_name_id)->value('bank_name');
//
//            return response()->json( array( $view_cashbook_entries, 'bank_name' => $bank_name) );
//        }
//    }

    public function delete_vendor_payment( Request $request, $cashbook_id) {
        if ( $request->ajax() ) {
            DB::table('cashbook_entries')->where('cashbook_id', $cashbook_id)->delete();
            DB::table('vendor_ledgers')->where('cashbook_id', $cashbook_id)->delete();
            return response()->json(['success' => 'Entry has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Entry', 'status' => 'failed']);
    }



    /***********************************
     * Account Head List
     * *********/

    public function new_account_head_save(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'account_head_type' => $request->account_head_type,
                'account_head_name' => $request->account_head_name,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('account_heads')->insertGetId( $data );

            $data['account_head_id'] = $lastId;
            return response()->json(['success' => 'Save Department Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_account_head(Request $request, $account_head_id) {
        if ( $request->ajax() ) {

            $account_head_info = DB::table('account_heads')->where('account_head_id', $account_head_id)->first();
            return response()->json( $account_head_info );
        }
    }

    public function update_account_head( Request $request ){
        if ( $request->ajax() ) {

            $account_head_id = $request->id;

            $data = array(
                'account_head_type' => $request->account_head_type,
                'account_head_name' => $request->account_head_name,
                'updated_at'    => date('Y-m-d H:i:s')
            );

            DB::table('account_heads')->where('account_head_id', $account_head_id)->update( $data );

            $data['account_head_id'] = $account_head_id;
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_account_head( Request $request, $account_head_id) {

        if ( $request->ajax() ) {
            DB::table('account_heads')->where('account_head_id', $account_head_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Department', 'status' => 'failed']);
    }

    public function cancel_update_account_head(Request $request) {
        if ( $request->ajax() ) {
            $account_head_id = $request->id;

            $account_head_info = DB::table('account_heads')->where('account_head_id', $account_head_id)->first();
            return response()->json( $account_head_info );
        }
    }

    public function cheque_book_status(Request $request) {
        if ( $request->ajax() ) {

            DB::table('bank_cheque_leafs')->where('cheque_leaf_id', $request->cheque_leaf_id)->update( ['cheque_status' => $request->cheque_status, 'leaf_unused_reason' => $request->leaf_reason ] );

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success', 'cheque_status' => $request->cheque_status, 'leaf_unused_reason' => $request->leaf_reason, 'cheque_leaf_id' => $request->cheque_leaf_id ]);
        }
    }

    public function balance_sheet() {
        $bank_balance = DB::table('bank_transactions')
            ->join('bank_accounts', 'bank_transactions.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit, bank_accounts.account_name, bank_transactions.account_number'))
            ->groupBy('account_name', 'account_number')
            ->get();

        $manage_bank = view('pages.accounts.balance-sheet')->with('bank_balance', $bank_balance);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function account_head_wise_summery() {

         $cashbook_infos = DB::table('cashbook_entries')
            ->leftJoin('account_heads', 'cashbook_entries.account_head_id', '=', 'account_heads.account_head_id')
            ->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit, account_heads.account_head_name'))
            ->groupBy('account_head_name')
            ->get();

        $manage_cashbook_entry = view('pages.accounts.account-headwise-summery')->with('cashbook_infos', $cashbook_infos);

        return view('dashboard')->with('main_content', $manage_cashbook_entry);
    }



    /***********************************
     * Asset List
     * *********/

    public function asset_list()
    {
        $asset_info = DB::table('assets')->get();
        $total_value = DB::table('assets')->select(DB::raw('SUM(asset_qty) as qty, SUM(asset_total_amount) as total_amount'))->first();
        $manage_asset = view('pages.accounts.asset-list')->with('all_asset_info', $asset_info)->with('total_value', $total_value);

        return view('dashboard')->with('main_content', $manage_asset);
    }

    public function new_asset_save( Request $request)
    {
//        $validatedData = $request->validate([
//            'title' => 'required|unique:assetsts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'asset_opening_date' => Carbon::createFromFormat('d/m/Y', $request->asset_opening_date )->format('Y-m-d H:i:s'),
            'asset_type'         => $request->asset_type,
            'asset_name'         => $request->asset_name,
            'asset_uom'          => $request->asset_uom,
            'asset_rate'         => $request->asset_rate,
            'asset_qty'          => $request->asset_qty,
            'asset_total_amount' => $request->asset_total_amount,
            'asset_description'  => $request->asset_description,
            'created_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('assets')->insert( $data );

        //Session::put('success', 'Created New Purchases Successfully!');
        //return Redirect::to('/new-asset');
        return redirect('/account/asset-list')->with('success', 'Created New Purchase Successfully!');
    }


    public function delete_asset( Request $request, $asset_id)
    {
        if ( $request->ajax() ) {
            DB::table('assets')->where('asset_id', $asset_id)->delete();
            return response()->json(['success' => 'Asset has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the asset', 'status' => 'failed']);
    }

    public function edit_asset(Request $request, $asset_id )
    {
        if ( $request->ajax() ) {
            $asset_info = DB::table('assets')->where('asset_id', $asset_id)->first();
            return response()->json( $asset_info );
        }
    }

    public function update_asset( Request $request )
    {
        $asset_id = $request->asset_id;

        $data = array(
            'asset_opening_date' => Carbon::createFromFormat('d/m/Y', $request->asset_opening_date )->format('Y-m-d H:i:s'),
            'asset_type'         => $request->asset_type,
            'asset_name'         => $request->asset_name,
            'asset_uom'          => $request->asset_uom,
            'asset_rate'         => $request->asset_rate,
            'asset_qty'          => $request->asset_qty,
            'asset_total_amount' => $request->asset_total_amount,
            'asset_description'  => $request->asset_description,
            'updated_at'         => date('Y-m-d H:i:s'),
        );
        DB::table('assets')->where('asset_id', $asset_id)->update( $data );

        return redirect('/account/asset-list')->with('success', 'Update Asset Successfully!');
    }
}
