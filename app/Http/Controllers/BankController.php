<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class BankController extends Controller
{
    public function bank_account_management() {

        $bank_ac_info = DB::table('bank_accounts')
            ->join('bank_name_lists', 'bank_accounts.bank_name_id', '=', 'bank_name_lists.bank_name_id')
            ->select('bank_accounts.*', 'bank_name_lists.bank_name as bank_name')
            ->get();
        $manage_bank = view('pages.banks.bank-account-management')->with('all_bank_ac_info', $bank_ac_info);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function new_bank_account_save( Request $request)
    {
        //$input = $request->all();
        //dd($input); //Dump and Die

//        $validatedData = $request->validate([
//            'title' => 'required|unique:posts|max:255',
//            'body' => 'required',
//        ]);

        $data = array();
        $data['account_name']    = $request->account_name;
        $data['account_number']  = $request->account_number;
        $data['bank_name_id']    = $request->bank_name_id;
        $data['branch']          = $request->branch;
        $data['account_type']    = $request->account_type;
        $data['swift_code']      = $request->swift_code;
        $data['opening_date']    = Carbon::createFromFormat('d/m/Y', $request->opening_date )->format('Y-m-d H:i:s');
        $data['website']         = $request->website;
        $data['email']           = $request->email;
        $data['phone']           = $request->phone;
        $data['alt_phone']       = $request->alt_phone;
        $data['percent']         = $request->percent;
        $data['bank_address']    = $request->bank_address;
        $data['bank_note']       = $request->bank_note;
        $data['created_at']      = date('Y-m-d H:i:s');

        DB::table('bank_accounts')->insert( $data );

        return redirect('/bank/bank-account-management')->with('success', 'New Bank Accounts Created Successfully!');
    }

    public function delete_bank_account( Request $request, $bank_account_id) {
        if ( $request->ajax() ) {
            DB::table('bank_accounts')->where('bank_account_id', $bank_account_id)->delete();
            return response()->json(['message' => 'Bank Account has been deleted successfully!']);
        }
        return response(['message' => 'Failed deleting the Bank Account']);
    }

    public function edit_bank_account(Request $request, $bank_account_id ) {
        if ( $request->ajax() ) {
            $bank_info = DB::table('bank_accounts')->where('bank_account_id', $bank_account_id)->first();
            return response()->json( $bank_info );
        }
    }

    public function update_bank_account( Request $request ){

        $bank_account_id = $request->bank_account_id;

        $data = array();
        $data['account_name']    = $request->account_name;
        $data['account_number']  = $request->account_number;
        $data['bank_name_id']    = $request->bank_name_id;
        $data['branch']          = $request->branch;
        $data['account_type']    = $request->account_type;
        $data['swift_code']      = $request->swift_code;
        $data['opening_date']    = Carbon::createFromFormat('d/m/Y', $request->opening_date )->format('Y-m-d H:i:s');
        $data['website']         = $request->website;
        $data['email']           = $request->email;
        $data['phone']           = $request->phone;
        $data['alt_phone']       = $request->alt_phone;
        $data['percent']         = $request->percent;
        $data['bank_address']    = $request->bank_address;
        $data['bank_note']       = $request->bank_note;
        $data['updated_at']      = date('Y-m-d H:i:s');

        DB::table('bank_accounts')->where('bank_account_id', $bank_account_id)->update( $data );

        return redirect('/bank/bank-account-management')->with('success', 'Update Bank Account Successfully!');
    }

    public function view_bank_account( Request $request, $bank_account_id )
    {
        if ( $request->ajax() ) {
            $view_bank_accounts = DB::table('bank_accounts')->where('bank_account_id', $bank_account_id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $view_bank_accounts->bank_name_id)->value('bank_name');

            return response()->json( array( $view_bank_accounts, 'bank_name' => $bank_name) );
        }
    }



    /***********************************
     * Cheque Book
     * *********/
    public function cheque_book_list() {

        $cheque_book_info = DB::table('bank_cheque_books')
        ->join('bank_accounts', 'bank_cheque_books.bank_account_id', '=', 'bank_accounts.bank_account_id')
        ->select('bank_cheque_books.*', 'bank_accounts.account_name as account_name')
        ->get();

        $manage_cheque_book = view('pages.banks.cheque-books-list')->with('cheque_book_info', $cheque_book_info);

        return view('dashboard')->with('main_content', $manage_cheque_book);
    }

    public function new_cheque_book(Request $request) {

        $data = array(
            'cheque_book_no'  => $request->cheque_book_no,
            'bank_name'       => $request->bank_name,
            'branch'          => $request->branch,
            'bank_account_id' => $request->bank_account_id,
            'account_number'      => $request->account_number,
            'issue_date'      => Carbon::createFromFormat('d/m/Y', $request->issue_date )->format('Y-m-d H:i:s'),
            'leaf_prefix'     => $request->leaf_prefix,
            'number_of_leafs' => $request->number_of_leafs,
            'first_cheque_no' => $request->first_cheque_no,
            'last_cheque_no'  => $request->last_cheque_no,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        $cheque_book_id = DB::table('bank_cheque_books')->insertGetId( $data );

        for ($x = $request->first_cheque_no; $x <= $request->last_cheque_no; $x++){
            $leaf_data = array(
                //'cheque_leaf_id'     => $x,
                'cheque_book_id'     => $cheque_book_id,
                'cheque_number'      => $request->leaf_prefix . $x,
                'cheque_leaf_status' => "Unused",
                //'leaf_unused_reason' => $request->leaf_unused_reason,
                //'leaf_issue_date'    => Carbon::createFromFormat('d/m/Y', $request->leaf_issue_date )->format('Y-m-d H:i:s'),
                'cheque_leaf_amount' => '0.00',
                //'voucher_id'         => $request->voucher_id,
                //'party_id'            => $request->party_id,
                //'party_type'          => $request->party_type,
                //'party_name'          => $request->party_name,
                //'user_id'            => Auth::id(),
                'created_at'         => date('Y-m-d H:i:s'),
            );
            DB::table('bank_cheque_leafs')->insert( $leaf_data );
        }
        return redirect('/bank/cheque-book-list')->with('success', 'Created Cheque Book Successfully!');
    }


    public function get_account_data(Request $request) {
        if ( $request->ajax() ) {
            $account_info = DB::table('bank_accounts')->where('bank_account_id', $request->id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $account_info->bank_name_id)->value('bank_name');

            return response()->json( array( $account_info, 'bank_name' => $bank_name) );    //return json_encode( $districts );
        }
    }

    public function edit_cheque_book(Request $request, $cheque_book_id){
        if ( $request->ajax() ) {
            $cheque_book_id_info = DB::table('bank_cheque_books')->where('cheque_book_id', $cheque_book_id)->first();
            return response()->json( $cheque_book_id_info );    //return json_encode( $districts );
        }
    }

    public function update_cheque_book_save(Request $request) {

        $cheque_book_id = $request->cheque_book_id;

        $data = array(
            'cheque_book_id'  => $cheque_book_id,
            'cheque_book_no'  => $request->cheque_book_no,
            'bank_name'       => $request->bank_name,
            'branch'          => $request->branch,
            'bank_account_id' => $request->bank_account_id,
            'account_number'  => $request->account_number,
            'issue_date'      => Carbon::createFromFormat('d/m/Y', $request->issue_date )->format('Y-m-d H:i:s'),
            //'leaf_prefix'     => $request->leaf_prefix,
            //'number_of_leafs' => $request->number_of_leafs,
            //'first_cheque_no' => $request->first_cheque_no,
            //'last_cheque_no'  => $request->last_cheque_no,
            'updated_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('bank_cheque_books')->where('cheque_book_id', $cheque_book_id)->update( $data );

        return redirect('/bank/cheque-book-list')->with('success', 'Update Check Book Successfully!');
    }

    public function view_cheque_book( $cheque_book_id ) {

        $cheque_leaf_info = DB::table('bank_cheque_leafs')
            ->join('bank_cheque_books', function ($join){ $join->on('bank_cheque_leafs.cheque_book_id', '=', 'bank_cheque_books.cheque_book_id'); })
            ->leftJoin('users', function ($join){ $join->on('bank_cheque_leafs.user_id', '=', 'users.id'); })
            ->where('bank_cheque_books.cheque_book_id', '=', $cheque_book_id)->get();

        $cheque_book_data = DB::table('bank_cheque_books')->where('cheque_book_id', $cheque_book_id)->value('cheque_book_no');

        $view_cheque_book = view('pages.banks.cheque-book-view')->with('cheque_leaf_info', $cheque_leaf_info)->with('cheque_book_no', $cheque_book_data)->with('cheque_book_id', $cheque_book_id);

        return view('dashboard')->with('main_content', $view_cheque_book);
    }

    public function cheque_book_status(Request $request, $cheque_book_id, $cheque_book_status) {
        if ( $request->ajax() ) {
            DB::table('bank_cheque_books')->where('cheque_book_id', $cheque_book_id)->update( ['cheque_book_status' => $cheque_book_status ] );
            return response()->json(['message' => 'Cheque Book Status changed successfully!', 'cheque_book_status' => $cheque_book_status ]);
        }
    }

    public function change_cheque_leaf_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('bank_cheque_leafs')->where('cheque_leaf_id', $request->cheque_leaf_id)->update( ['cheque_leaf_status' => $request->cheque_leaf_status, 'leaf_unused_reason' => $request->leaf_reason ] );
            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success', 'cheque_leaf_status' => $request->cheque_leaf_status, 'leaf_unused_reason' => $request->leaf_reason, 'cheque_leaf_id' => $request->cheque_leaf_id ]);
        }
    }

    public function view_cheque( Request $request, $cheque_number )
    {
        if ( $request->ajax() ) {
            $view_cheque = DB::table('bank_transactions')->where('cheque_number', $cheque_number )->first();
            $account_data = DB::table('bank_accounts')->where('bank_account_id', $view_cheque->bank_account_id )->select('account_name', 'swift_code', 'bank_name_id', 'branch')->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $account_data->bank_name_id )->value('bank_name');

            //$obj = new \TakaToWordConverter\WordConverter();
            //$in_word =  $obj->convert($view_cheque->debit);
            $in_word =  taka_in_words( $view_cheque->debit);

            $date_span = str_split( date('dmY', strtotime($view_cheque->cheque_date)) );

            return response()->json( array( $view_cheque, 'account_data'=>$account_data, 'bank_name'=>$bank_name, "in_word"=>$in_word, 'date_span'=>$date_span) );
        }
    }

    public function delete_cheque_book( Request $request, $cheque_book_id) {
        if ( $request->ajax() ) {
            DB::table('bank_cheque_books')->where('cheque_book_id', $cheque_book_id)->delete();

            $cheque_leaf_ids = DB::table('bank_cheque_leafs')->where('cheque_book_id', $cheque_book_id)->select('cheque_leaf_id')->get();
            foreach($cheque_leaf_ids as $cheque_leaf_id){
                DB::table('bank_cheque_leafs')->where('cheque_leaf_id', $cheque_leaf_id->cheque_leaf_id)->delete();
            }
            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Designation', 'status' => 'failed']);
    }



    /***********************************
     * Cheque Payment
     * *********/

    public function cheque_payment_list() {
        $cheque_payment_info = DB::table('bank_cheque_payments')
                ->leftJoin('bank_accounts', 'bank_cheque_payments.bank_account_id', '=', 'bank_accounts.bank_account_id')
                ->select('bank_cheque_payments.*', 'bank_accounts.account_name')
                ->orderBy('cheque_payment_id', 'desc')->get();

        $manage_cheque_payment = view('pages.banks.cheque-payment-list')->with('cheque_payment_info', $cheque_payment_info);

        return view('dashboard')->with('main_content', $manage_cheque_payment);
    }

    public function new_cheque_payment(Request $request) {
        $data = array(
            'payment_date'          => Carbon::createFromFormat('d/m/Y', $request->payment_date )->format('Y-m-d H:i:s'),
            'party_type'            => $request->party_type,
            'party_id'              => $request->party_id,
            'party_name'            => $request->party_name,
            'bank_account_id'       => $request->bank_account_id,
            'account_number'        => $request->account_number,
            'bank_name'             => $request->bank_name,
            'branch'                => $request->branch,
            'cheque_book_id'        => $request->cheque_book_id,
            //'cheque_leaf_id'        => $request->cheque_leaf_id,
            'cheque_number'         => $request->cheque_number,
            'cheque_type'           => $request->cheque_type,
            'cheque_date'           => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
            'cheque_amount'         => $request->cheque_amount,
            'cheque_payment_desc'   => $request->cheque_payment_desc,
            'cheque_payment_status' => 'Pending',
            'user_id'               => Auth::id(),
            'created_at'            => date('Y-m-d H:i:s'),
        );
        DB::table('bank_cheque_payments')->insert( $data );


        $leaf_data = array(
            'leaf_issue_date'    => Carbon::createFromFormat('d/m/Y', $request->payment_date )->format('Y-m-d H:i:s'),
            'cheque_leaf_amount' => $request->cheque_amount,
            'voucher_id'         => $request->voucher_id,
            'party_id'           => $request->party_id,
            'party_type'         => $request->party_type,
            'party_name'         => $request->party_name,
            'cheque_leaf_status' => "Used",
            'user_id'            => Auth::id(),
        );
        DB::table('bank_cheque_leafs')->where('cheque_number', $request->cheque_number)->update( $leaf_data );


        $trx_data = array(
            'trx_date'         => Carbon::createFromFormat('d/m/Y', $request->payment_date )->format('Y-m-d H:i:s'),
            'trx_type'         => 'cheque_payment',
            'party_type'       => $request->party_type,
            'party_id'         => $request->party_id,
            'party_name'       => $request->party_name,
            'voucher_id'       => $request->voucher_id,
            'bank_account_id'  => $request->bank_account_id,
            'account_number'   => $request->account_number,
            'cheque_number'    => $request->cheque_number,
            'cheque_date'      => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
            //'bank_date'        => '',
            'cheque_type'      => $request->cheque_type,
            'debit'           => $request->cheque_amount,
            'created_at'       => date('Y-m-d H:i:s'),
        );
        DB::table('bank_transactions')->insert( $trx_data );

        return redirect('/bank/cheque-payment-list')->with('success', 'Add Cheque payment Successfully!');
    }

    public function get_cheque_book_data(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->first();

            //for loop cheque book dropdown
            $cheque_book_data = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->where("cheque_book_status", '=', 'open')->pluck("cheque_book_no", 'cheque_book_id');

            return response()->json( [$account_info, 'cheque_book'=>$cheque_book_data] );
        }
    }

    public function get_cheque_leaf(Request $request)
    {
        if ( $request->ajax() ) {
            $check_leafs = DB::table("bank_cheque_leafs")->where("cheque_book_id", $request->id)->where("cheque_leaf_status", '=', 'Unused')->pluck('cheque_number', 'cheque_leaf_id');
            return response()->json( $check_leafs );
        }
    }

    public function cheque_payment_status(Request $request)
    {
        $cheque_payment_id = $request->id;

        if ( $request->ajax() ) {
            DB::table('bank_cheque_payments')->where('cheque_payment_id', $cheque_payment_id)->update( ['cheque_payment_status' => $request->data] );
            return response()->json( ['status' => $request->data, 'success'=> 'Cheque Status Changed Successfully!'] );
        }
    }

    public function get_party_name(Request $request)
    {
        $parties = array();

        if($request->type == 'vendor'){
            $parties []= DB::table("vendor")->select(DB::raw("CONCAT(vendor_name,' - ', company_name) AS vendor_name, vendor_id"))->pluck("vendor_name", 'vendor_id');
        }
        else if($request->type == 'employee'){
            $parties []= DB::table("employees")
                    ->join('designations', 'employees.designation_id', 'designations.designation_id')
                    ->select(DB::raw("CONCAT(employee_name, ' - ', designation_name) AS employee_name, employee_id"))
                    ->pluck("employee_name", 'employee_id');
        }
        else if($request->type == 'customer'){
            $parties []= DB::table("customers")->pluck("customer_name", 'customer_id');
        }
        else if($request->type == 'supplier'){
            $parties []= DB::table("suppliers")->pluck('supplier_name', 'supplier_id');
        }
        else if($request->type == 'other_party'){
            $parties []= DB::table("vendors")->pluck("vendor_name", 'vendor_id');
        }

        $parties['type']= $request->type;

        if ( $request->ajax() ) {
            return response()->json( $parties );
        }
    }

    public function view_cheque_payment( Request $request, $cheque_payment_id )
    {
        if ( $request->ajax() ) {
            $view_cheque_payments = DB::table('bank_cheque_payments')->where('cheque_payment_id', $cheque_payment_id )->first();
            $account_name = DB::table('bank_accounts')->where('bank_account_id', $view_cheque_payments->bank_account_id)->value('account_name');

            return response()->json( array( $view_cheque_payments, 'account_name' => $account_name) );
        }
    }

    public function get_balance(Request $request)
    {
        if ( $request->ajax() ) {
            $total_query = DB::table('bank_transactions')->where('bank_account_id', $request->bank_account_id)->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first();
            $balance = $total_query->credit - $total_query->debit;

            //return json_encode( $districts );
            return response()->json( $balance );
        }
    }


    /***********************************
     * Cash Withdraw
     * *********/

    public function cash_withdraw_list() {
        $cash_withdraw_info = DB::table('cash_withdraws')
            ->leftJoin('bank_accounts', 'cash_withdraws.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->select('cash_withdraws.*', 'bank_accounts.account_name')
            ->orderBy('withdraw_id', 'desc')->get();

        $manage_cash_withdraw = view('pages.banks.cash-withdraw-list')->with('cash_withdraw_info', $cash_withdraw_info);

        return view('dashboard')->with('main_content', $manage_cash_withdraw);
    }

    public function cash_withdraw_save(Request $request) {
        $data = array(
            'withdraw_date'   => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            //'party_type'    => 'Self',
            //'party_id'      => $request->party_id,
            //'party_name'    => settings('company_name'),
            'bank_account_id' => $request->bank_account_id,
            'account_number'  => $request->account_number,
            'bank_name'       => $request->bank_name,
            'branch'          => $request->branch,
            'cheque_book_id'  => $request->cheque_book_id,
            //'cheque_leaf_id'=> $request->cheque_leaf_id,
            'cheque_number'   => $request->cheque_number,
            //'cheque_type'   => 'Cash Cheque',
            'cheque_date'     => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            'cheque_amount'   => $request->cheque_amount,
            'withdraw_desc'   => $request->withdraw_desc,
            'withdraw_status' => 'Pending',
            'user_id'         => Auth::id(),
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('cash_withdraws')->insert( $data );


        //Update cheque leaf, because leaf is made with cheque book created.
        $leaf_data = array(
            'leaf_issue_date'    => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            'cheque_leaf_amount' => $request->cheque_amount,
            'voucher_id'         => $request->voucher_id,
            //'party_id'           => $request->party_id,
            'party_type'         => 'Self',
            'party_name'         => settings('company_name'),
            'cheque_leaf_status' => "Used",
            'user_id'            => Auth::id(),
        );
        DB::table('bank_cheque_leafs')->where('cheque_number', $request->cheque_number)->update( $leaf_data );

        $trx_data = array(
            'trx_date'        => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            'trx_type'        => 'cash_withdraw',
            'party_type'      => 'Self',
            //'party_id'         => $request->party_id,
            'party_name'      => settings('company_name'),
            'voucher_id'      => $request->voucher_id,
            'bank_account_id' => $request->bank_account_id,
            'account_number'  => $request->account_number,
            'cheque_number'   => $request->cheque_number,
            'cheque_date'     => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            'cheque_type'     => 'Cash Cheque',
            'debit'           => $request->cheque_amount,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('bank_transactions')->insert( $trx_data );

        return redirect('/bank/cash-withdraw-list')->with('success', 'Add Withdraw Successfully!');
    }

    public function get_cheque_book_data_to_withdraw(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->first();

            //for loop cheque book dropdown
            $cheque_book_data = DB::table("bank_cheque_books")->where("bank_account_id", $request->bank_account_id)->where("cheque_book_status", '=', 'open')->pluck("cheque_book_no", 'cheque_book_id');

            return response()->json( [$account_info, 'cheque_book'=>$cheque_book_data] );
        }
    }

    public function get_cheque_leaf_to_withdraw(Request $request)
    {
        if ( $request->ajax() ) {
            $check_leafs = DB::table("bank_cheque_leafs")->where("cheque_book_id", $request->id)->where("cheque_leaf_status", '=', 'Unused')->pluck('cheque_number', 'cheque_leaf_id');
            return response()->json( $check_leafs );
        }
    }

    public function withdraw_status(Request $request) {

        $withdraw_id = $request->id;

        if ( $request->ajax() ) {
            DB::table('cash_withdraws')->where('withdraw_id', $withdraw_id)->update( ['withdraw_status' => $request->data] );
            return response()->json( ['status' => $request->data, 'success'=> 'Withdraw Status Changed Successfully!'] );
        }
    }




    /***********************************
     * Cash Deposit
     * *********/

    public function cash_deposit_list() {
        $cash_deposit_info = DB::table('cash_deposits')
            ->leftJoin('bank_accounts', 'cash_deposits.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->select('cash_deposits.*', 'bank_accounts.account_name')
            ->orderBy('cash_deposit_id', 'desc')->get();

        $manage_cash_deposit = view('pages.banks.cash-deposit-list')->with('cash_deposit_info', $cash_deposit_info);

        return view('dashboard')->with('main_content', $manage_cash_deposit);
    }

    public function cash_deposit_save(Request $request) {
        $data = array(
            'cash_deposit_date'   => Carbon::createFromFormat('d/m/Y', $request->cash_deposit_date )->format('Y-m-d H:i:s'),
            'bank_account_id'     => $request->bank_account_id,
            'account_number'      => $request->account_number,
            'bank_name'           => $request->bank_name,
            'branch'              => $request->branch,
            'cash_deposit_amount' => $request->cash_deposit_amount,
            'cash_deposit_desc'   => $request->cheque_payment_desc,
            'user_id'             => Auth::id(),
            'created_at'          => date('Y-m-d H:i:s'),
        );
        DB::table('cash_deposits')->insert( $data );

        $trx_data = array(
            'trx_date'        => Carbon::createFromFormat('d/m/Y', $request->cash_deposit_date )->format('Y-m-d H:i:s'),
            'trx_type'        => 'cash_deposit',
            'party_type'      => 'Self',
            //'party_id'         => $request->party_id,
            'party_name'      => settings('company_name'),
            'voucher_id'      => $request->voucher_id,
            'bank_account_id' => $request->bank_account_id,
            'account_number'  => $request->account_number,
            //'cheque_number'   => $request->cheque_number,
            //'cheque_date'     => Carbon::createFromFormat('d/m/Y', $request->withdraw_date )->format('Y-m-d H:i:s'),
            //'bank_date'      => '',
            //'cheque_type'     => '',
            'credit'          => $request->cash_deposit_amount,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('bank_transactions')->insert( $trx_data );

        return redirect('/bank/cash-deposit-list')->with('success', 'Add Cash Deposit Successfully!');
    }

    public function get_account_data_to_cash_deposit(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table('bank_accounts')->where('bank_account_id', $request->bank_account_id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $account_info->bank_name_id)->value('bank_name');

            return response()->json( array( $account_info, 'bank_name' => $bank_name) );
        }
    }

    public function view_cash_deposit( Request $request, $cheque_payment_id )
    {
        if ( $request->ajax() ) {
            $view_cheque_payments = DB::table('cash_deposits')->where('cash_deposit_id', $cheque_payment_id )->first();
            $account_name = DB::table('bank_accounts')->where('bank_account_id', $view_cheque_payments->bank_account_id)->value('account_name');

            return response()->json( array( $view_cheque_payments, 'account_name' => $account_name) );
        }
    }



    /***********************************
     * Received Cheques
     * *********/
    public function received_cheques() {
        $received_cheque_info = DB::table('bank_received_cheques')
            ->leftJoin('clients', 'bank_received_cheques.client_id', '=', 'clients.client_id')
            ->select('bank_received_cheques.*', 'clients.client_name')
            ->orderBy('bank_received_cheques.created_at', 'DESC')

            ->get();

        $manage_bank = view('pages.banks.received-cheques')->with('received_cheque_info', $received_cheque_info);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function new_received_cheque(Request $request)
    {
        //dd($request->all());
        DB::table('bank_received_cheques')->insert(array(
            'received_date'     => Carbon::createFromFormat('d/m/Y', $request->received_date )->format('Y-m-d H:i:s'),
            'client_id'         => $request->client_id,
            'client_bank'       => $request->client_bank,
            'bank_account_id'   => $request->bank_account_id,
            'received_bank'     => $request->received_bank,
            'received_branch'   => $request->received_branch,
            'money_receipt_no'  => $request->money_receipt_no,
            'cheque_number'     => $request->cheque_number,
            'cheque_date'       => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
            'cheque_type'       => $request->cheque_type,
            'cheque_amount'     => $request->cheque_amount,
            'collection_person' => $request->collection_person,
            'po_id'             => $request->po_id,
            //'project_name'      => $request->project_name,
            //'po_number'         => $request->po_number,
            //'po_date'           => Carbon::createFromFormat('d/m/Y', $request->po_date )->format('Y-m-d H:i:s'),
            'client_bill_id'    => $request->client_bill_id,
            //'bill_no'           => $request->bill_no,
            //'bill_date'         => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
            'description'       => $request->description,
            'received_cheque_status'     => 'on_hand',
            //'dr_account'      => $request->dr_account,
            'created_at'        => date('Y-m-d H:i:s'),
        ));

        DB::table('bank_transactions')->insert(array(
            'trx_date'         => Carbon::createFromFormat('d/m/Y', $request->received_date )->format('Y-m-d H:i:s'),
            'trx_type'         => 'cheque_received',
            'party_id'         => $request->client_id,
            'party_type'       => 'client',
            //'party_name'       => $request->party_name,
            //'voucher_id'       => $request->voucher_id,
            'bank_account_id'  => $request->bank_account_id,
            'account_number'   => $request->account_number,
            'cheque_number'    => $request->cheque_number,
            'cheque_date'      => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
            'cheque_type'      => $request->cheque_type,
            'credit'           => $request->cheque_amount,
            'created_at'       => date('Y-m-d H:i:s'),
        ));

        //Insert data to Client Ledgers & Client Bills
        DB::table('client_ledgers')->insert(array(
            'client_id'         => $request->client_id,
            'client_bill_id'    => $request->client_bill_id,
            'bill_status'       => $request->bill_status,
            'bill_no'           => $request->bill_no,
            'bill_date'         => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
            'po_id'             => $request->po_id,
            'po_number'         => $request->po_number,
            'project_name'      => $request->project_name,
            'received_method'   => "Cheque",
            //'billing_amount'    => $request->billing_amount,
            'received_amount'   => $request->cheque_amount,
            'user_id'           => Auth::id(),
            'created_at'        => date('Y-m-d H:i:s'),
        ));

        DB::table('client_bills')->where('client_bill_id', $request->client_bill_id)->update([
            'received_amount'=>$request->cheque_amount,
            'bill_status'=>$request->bill_status
        ]);

        return redirect('/bank/received-cheques')->with('success', 'Add Cheque received Successfully!');
    }

    public function update_received_cheque(Request $request)
    {
        $received_cheque_id = $request->received_cheque_id;

        $data = array(


            'cheque_payment_id'  => $received_cheque_id,
            'received_cheque_status'     => 'on_hand',
            //'dr_account'      => $request->dr_account,
            //'tag_so'          => $request->tag_so,
            'updated_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('bank_received_cheques')->where('received_cheque_id', $received_cheque_id)->update( $data );

        return redirect('/bank/received-cheques')->with('success', 'Update Cheque Received Successfully!');
    }

    public function view_received_cheque( Request $request, $received_cheque_id )
    {
        if ( $request->ajax() ) {
            $view_received_cheques = DB::table('bank_received_cheques')->where('received_cheque_id', $received_cheque_id )->first();
            $client_name = DB::table('clients')->where('client_id', $view_received_cheques->client_id)->value('client_name');

            $account = DB::table('bank_accounts')->select('account_name', 'account_number')->where('bank_account_id', $view_received_cheques->bank_account_id)->first();
            $po = DB::table('purchase_orders')->select('po_number', 'po_date')->where('po_id', $view_received_cheques->po_id )->first();
            $client_bill = DB::table('client_bills')->select('bill_no', 'bill_date')->where('client_bill_id', $view_received_cheques->client_bill_id )->first();

            return response()->json( array( $view_received_cheques, 'client_name' => $client_name, 'account'=>$account, 'po'=>$po, 'client_bill'=>$client_bill) );
        }
    }

    public function view_change_history( Request $request, $received_cheque_id )
    {
        if ( $request->ajax() ) {
            $view_received_cheques = DB::table('bank_received_cheques')->where('received_cheque_id', $received_cheque_id )->first();
            $client_name = DB::table('clients')->where('client_id', $view_received_cheques->client_id)->value('client_name');
                $change_histories = DB::table('bank_received_cheque_change_histories')->where('received_cheque_id', $received_cheque_id)->get();

            return response()->json( array( $view_received_cheques, 'client_name' => $client_name, 'change_histories' => $change_histories) );
        }
    }

    public function received_cheque_status(Request $request)
    {
        $received_cheque_id = $request->received_cheque_id;

        if ( $request->ajax() ) {
            DB::table('bank_received_cheques')->where('received_cheque_id', $received_cheque_id)->update( ['received_cheque_status' => $request->received_cheque_status] );

            $data = array(
                'received_cheque_status' => $request->received_cheque_status,
                'transaction_date' => date('Y-m-d H:i:s'),
                'description' => $request->description,
                'received_cheque_id' => $received_cheque_id,
            );
            DB::table('bank_received_cheque_change_histories')->insert( $data );

            return response()->json( ['status' => $request->received_cheque_status, 'success'=> 'Cheque Status Changed Successfully!'] );
        }
    }

    public function get_account_data_to_rec_cheque(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table('bank_accounts')->where('bank_account_id', $request->bank_account_id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $account_info->bank_name_id)->value('bank_name');

            return response()->json( array( $account_info, 'bank_name' => $bank_name) );
        }
    }

    public function reload_client(Request $request)
    {
        if ( $request->ajax() ) {
            $all_client = DB::table("clients")->pluck("client_name","client_id");
            return response()->json( $all_client );
        }
    }

    public function get_bill_list(Request $request)
    {
        if ( $request->ajax() ) {
            $bill_list = DB::table("client_bills")->where('client_id', $request->client_id)->pluck("bill_no","client_bill_id");
            return response()->json( $bill_list );
        }
    }

    public function get_po_and_bill_data(Request $request)
    {
        if ( $request->ajax() ) {
            $bill_info = DB::table("client_bills")->where('bill_no', $request->bill_no)->select('client_bill_id', 'bill_date', 'po_id')->first();

            $po_data = DB::table("purchase_orders")->where('po_id', $bill_info->po_id)->select('po_id', 'po_number', 'po_date', 'project_name')->first();
            return response()->json( [$po_data, 'bill_date'=>$bill_info->bill_date, 'client_bill_id'=>$bill_info->client_bill_id ] );
        }
    }



    /***********************************
     * Bank Transfers
     * *********/
    public function bank_transfer_list() {
        $bank_transfer_info = DB::table('bank_transfers')
            ->leftJoin('bank_accounts', 'bank_transfers.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->leftJoin('clients', 'bank_transfers.client_id', '=', 'clients.client_id')
            ->select('bank_transfers.*', 'bank_accounts.account_name', 'clients.client_name')
            ->orderBy('bank_transfers.created_at', 'DESC')
            ->get();

        $manage_bank = view('pages.banks.bank-transfer-list')->with('bank_transfer_info', $bank_transfer_info);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function new_bank_transfer(Request $request)
    {
        //dd($request->all());
        DB::table('bank_transfers')->insert(array(
            'transfer_date'      => Carbon::createFromFormat('d/m/Y', $request->transfer_date )->format('Y-m-d H:i:s'),
            'client_id'          => $request->client_id,
            'transfer_reference' => $request->transfer_reference,
            'bank_account_id'    => $request->bank_account_id,
            'account_number'     => $request->account_number,
            'bank_name'          => $request->bank_transfer_bank,
            'bank_branch'        => $request->bank_transfer_branch,
            'transfer_amount'    => $request->transfer_amount,
            'client_bill_id'    => $request->client_bill_id,
            //'bill_no'            => $request->bill_no,
            //'bill_date'          => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
            'po_id'             => $request->po_id,
            //'po_number'          => $request->po_number,
            //'po_date'            => Carbon::createFromFormat('d/m/Y', $request->po_date )->format('Y-m-d H:i:s'),
            'description'        => $request->description,
            'created_at'         => date('Y-m-d H:i:s'),
        ));


        DB::table('bank_transactions')->insert(array(
            'trx_date'         => Carbon::createFromFormat('d/m/Y', $request->transfer_date )->format('Y-m-d H:i:s'),
            'trx_type'         => 'bank_transfer',
            'party_id'         => $request->client_id,
            'party_type'       => 'client',
            //'party_name'       => $request->party_name,
            //'voucher_id'       => $request->voucher_id,
            'bank_account_id'  => $request->bank_account_id,
            'account_number'   => $request->account_number,
            //'cheque_number'    => $request->cheque_number,
            //'cheque_date'      => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
            //'cheque_type'      => $request->cheque_type,
            'credit'           => $request->transfer_amount,
            'created_at'       => date('Y-m-d H:i:s'),
        ));


        //Insert data to Client Ledgers & Client Bills
        DB::table('client_ledgers')->insert(array(
            'client_id'         => $request->client_id,
            'client_bill_id'    => $request->client_bill_id,
            'bill_status'       => $request->bill_status,
            'bill_no'           => $request->bill_no,
            'bill_date'         => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
            'po_id'             => $request->po_id,
            'po_number'         => $request->po_number,
            'project_name'      => $request->project_name,
            'received_method'   => "Bank Transfer",
            //'billing_amount'    => $request->billing_amount,
            'received_amount'   => $request->transfer_amount,
            'user_id'           => Auth::id(),
            'created_at'        => date('Y-m-d H:i:s'),
        ));


        DB::table('client_bills')->where('client_bill_id', $request->client_bill_id)->update([
            'received_amount'=>$request->transfer_amount,
            'bill_status'=>$request->bill_status
        ]);

        return redirect('/bank/bank-transfer-list')->with('success', 'Add Cheque received Successfully!');
    }

    public function update_bank_transfer(Request $request) {
        $transfer_id = $request->transfer_id;

        $data = array(
//            'received_date'     => Carbon::createFromFormat('d/m/Y', $request->received_date )->format('Y-m-d H:i:s'),
//            'client_id'         => $request->client_id,
//            'cheque_number'     => $request->cheque_number,
//            'cheque_date'       => Carbon::createFromFormat('d/m/Y', $request->cheque_date )->format('Y-m-d H:i:s'),
//            'cheque_type'       => $request->cheque_type,
//            'client_bank'       => $request->client_bank,
//            'received_bank'     => $request->received_bank,
//            'received_branch'   => $request->received_branch,
//            'money_receipt_no'  => $request->money_receipt_no,
//            'cheque_amount'     => $request->cheque_amount,
//            'collection_person' => $request->collection_person,
//            'project_name'      => $request->project_name,
//            'po_number'         => $request->po_number,
//            'po_date'           => Carbon::createFromFormat('d/m/Y', $request->po_date )->format('Y-m-d H:i:s'),
//            'bill_no'           => $request->bill_no,
//            'bill_date'         => Carbon::createFromFormat('d/m/Y', $request->bill_date )->format('Y-m-d H:i:s'),
//            'description'       => $request->description,

            'cheque_payment_id'  => $transfer_id,
            'bank_transfer_status'     => 'on_hand',
            //'dr_account'      => $request->dr_account,
            //'tag_so'          => $request->tag_so,
            'updated_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('bank_transfers')->where('transfer_id', $transfer_id)->update( $data );

        return redirect('/bank/bank-transfer-list')->with('success', 'Update Cheque Received Successfully!');
    }

    public function view_bank_transfer( Request $request, $transfer_id )
    {
        if ( $request->ajax() ) {
            $view_bank_transfers = DB::table('bank_transfers')->where('transfer_id', $transfer_id )->first();
            $client_name = DB::table('clients')->where('client_id', $view_bank_transfers->client_id)->value('client_name');
            $account = DB::table('bank_accounts')->select('account_name', 'account_number')->where('bank_account_id', $view_bank_transfers->bank_account_id)->first();

            $po = DB::table('purchase_orders')->select('po_number', 'po_date')->where('po_id', $view_bank_transfers->po_id )->first();
            $client_bill = DB::table('client_bills')->select('bill_no', 'bill_date')->where('client_bill_id', $view_bank_transfers->client_bill_id )->first();

            return response()->json( array( $view_bank_transfers, 'client_name' => $client_name, 'account'=>$account, 'po'=>$po, 'client_bill'=>$client_bill) );
        }
    }

    public function get_account_data_to_bank_transfer(Request $request)
    {
        if ( $request->ajax() ) {
            $account_info = DB::table('bank_accounts')->where('bank_account_id', $request->bank_account_id )->first();
            $bank_name = DB::table('bank_name_lists')->where('bank_name_id', $account_info->bank_name_id)->value('bank_name');

            return response()->json( array( $account_info, 'bank_name' => $bank_name) );
        }
    }


    /***********************************
     * Bank Name List
     * *********/
    public function new_bank_name_save(Request $request) {
        if ( $request->ajax() ) {
            $data = array(
                'bank_name' => $request->bank_name,
                'created_at' => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('bank_name_lists')->insertGetId( $data );

            $data['bank_name_id'] = $lastId;
            return response()->json(['success' => 'Save Designation Successfully!', $data, 'status' => 'success']);
        }
    }

    public function edit_bank_name(Request $request, $bank_name_id) {
        if ( $request->ajax() ) {
            $bank_name_info = DB::table('bank_name_lists')->where('bank_name_id', $bank_name_id)->first();
            return response()->json( $bank_name_info );
        }
    }

    public function update_bank_name( Request $request ){
        if ( $request->ajax() ) {
            $data = array(
                'bank_name' => $request->bank_name,
                'bank_name_id' => $request->id,
                'updated_at' => date('Y-m-d H:i:s'),
            );
            DB::table('bank_name_lists')->where('bank_name_id', $request->id)->update( $data );

            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function delete_bank_name( Request $request, $bank_name_id) {
        if ( $request->ajax() ) {
            DB::table('bank_name_lists')->where('bank_name_id', $bank_name_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Designation', 'status' => 'failed']);
    }

    public function cancel_update_bank_name(Request $request) {
        if ( $request->ajax() ) {
            $bank_name_info = DB::table('bank_name_lists')->where('bank_name_id', $request->id)->first();
            return response()->json( $bank_name_info );
        }
    }

    public function bank_transaction() {
        $transaction_info = DB::table('bank_transactions')
            ->leftJoin('bank_accounts', 'bank_transactions.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->select('bank_transactions.*', 'bank_accounts.account_name')
            ->orderBy('created_at', 'desc')->get();

        $manage_bank = view('pages.banks.bank-transaction')->with('transaction_info', $transaction_info);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function bank_transaction_summery() {
        $first_day = Carbon::now()->firstOfMonth();
        $last_day = Carbon::now()->lastOfMonth();

        $transaction_summery = DB::table('bank_transactions')
            ->leftJoin('bank_accounts', 'bank_transactions.bank_account_id', '=', 'bank_accounts.bank_account_id')
            ->select(DB::raw('bank_transactions.bank_name, bank_accounts.account_name, bank_accounts.account_number, SUM(credit - debit) AS balances, SUM(credit) AS credit, SUM(debit) AS debit'))
            ->groupBy('bank_name', 'account_name', 'account_number')
            ->whereBetween('trx_date', [$first_day, $last_day])
            ->get();

        $total_query = DB::table('bank_transactions')->whereMonth('trx_date', date('m'))->select(DB::raw('SUM(credit) as credit, SUM(debit) as debit'))->first();

        $manage_bank = view('pages.banks.bank-transaction-summery', compact('transaction_summery', 'first_day', 'last_day', 'total_query'));

        return view('dashboard')->with('main_content', $manage_bank);
    }
}
