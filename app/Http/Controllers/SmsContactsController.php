<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;


class SmsContactsController extends Controller
{
    public function contact_list()
    {
        $contact_info = DB::table('contacts')
            ->leftjoin('contact_groups', 'contacts.group_id', '=', 'contact_groups.group_id')
            ->select('contacts.*', 'contact_groups.group_name')
            ->get();
        $manage_contact = view('emails.contact-list')->with('all_contact_info', $contact_info);

        return view('dashboard')->with('main_content', $manage_contact);
    }

    public function new_contact_save( Request $request)
    {
        //dd($request->all());
//        $validatedData = $request->validate([
//            'title' => 'required|unique:contactsts|max:255',
//            'body' => 'required',
//        ]);

        $data = array(
            'contact_name'    => $request->contact_name,
            'contact_mobile'  => $request->contact_mobile,
            'contact_email'   => $request->contact_email,
            'operator'        => $request->operator,
            'group_id'        => $request->group_id,
            'contact_status'  => 'active',
            'created_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('contacts')->insert( $data );

        return redirect('/notification/contact-list')->with('success', 'Created New Group Successfully!');
    }

    public function edit_contact(Request $request, $contact_id )
    {
        if ( $request->ajax() ) {
            $contact_info = DB::table('contacts')->where('contact_id', $contact_id)->first();
            return response()->json( $contact_info );
        }
    }

    public function update_contact( Request $request )
    {
        $contact_id = $request->contact_id;

        $data = array(
            'contact_name'    => $request->contact_name,
            'contact_mobile'  => $request->contact_mobile,
            'contact_email'   => $request->contact_email,
            'operator'        => $request->operator,
            'group_id'        => $request->group_id,
            'contact_status'  => 'active',
            'updated_at'      => date('Y-m-d H:i:s'),
        );
        DB::table('contacts')->where('contact_id', $contact_id)->update( $data );

        return redirect('/notification/contact-list')->with('success', 'Update contact Successfully!');
    }

    public function delete_contact( Request $request, $contact_id)
    {
        if ( $request->ajax() ) {
            DB::table('contacts')->where('contact_id', $contact_id)->delete();
            return response()->json(['success' => 'contact has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the contact', 'status' => 'failed']);
    }



    public function contact_group()
    {
        $group_info = DB::table('contact_groups')->get();
        $manage_group = view('emails.group-list')->with('all_group_info', $group_info);

        return view('dashboard')->with('main_content', $manage_group);
    }

    public function new_group_save( Request $request)
    {
        $data = array(
            'group_name' => $request->group_name,
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('contact_groups')->insert( $data );

        return redirect('/notification/contact-group')->with('success', 'Created New Group Successfully!');
    }

    public function edit_group(Request $request, $group_id )
    {
        if ( $request->ajax() ) {
            $group_info = DB::table('contact_groups')->where('group_id', $group_id)->first();
            return response()->json( $group_info );
        }
    }

    public function update_group( Request $request )
    {
        $group_id = $request->group_id;

        $data = array(
            'group_name' => $request->group_name,
            'updated_at' => date('Y-m-d H:i:s'),
        );
        DB::table('contact_groups')->where('group_id', $group_id)->update( $data );

        return redirect('/notification/contact-group')->with('success', 'Update group Successfully!');
    }

    public function delete_group( Request $request, $group_id)
    {
        if ( $request->ajax() ) {
            DB::table('contact_groups')->where('group_id', $group_id)->delete();
            return response()->json(['success' => 'group has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the group', 'status' => 'failed']);
    }
}
