<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\Paginator;

class ToDoListController extends Controller
{
    public function new_todo_save(Request $request) {
        if ( $request->ajax() ) {
            $max_order = DB::table('todo_lists')->max('todo_id'); $id = $max_order<1 ? 1 : $max_order+1;
            $data = array(
                'todo_name'   => $request->todo_name,
                'todo_description' => $request->todo_description,
                'color_name'  => $request->color_name,
                'status'      => 'active',
                'user_id'     => Auth::id(),
                'list_order'  => $id,
                'created_at'  => date('Y-m-d H:i:s'),
            );
            $lastId = DB::table('todo_lists')->insertGetId( $data );

            $data['todo_id'] = $lastId;
            $data['human_date'] = human_date( date('Y-m-d H:i:s') );

            return response()->json(['success' => 'Save Todo Successfully!', 'status' => 'success', $data ]);
        }
    }

    public function edit_todo(Request $request, $todo_id) {
        if ( $request->ajax() ) {

            $todo_info = DB::table('todo_lists')->where('todo_id', $todo_id)->first();
            return response()->json( $todo_info );
        }
    }

    public function update_todo( Request $request ){
        if ( $request->ajax() ) {
            $todo_id = $request->todo_id;

            $data = array(
                'todo_name'   => $request->todo_name,
                'todo_description' => $request->todo_description,
                'color_name'  => $request->color_name,
                'status'      => 'active',
                'user_id'     => Auth::id(),
                'created_at'  => date('Y-m-d H:i:s'),
            );
            DB::table('todo_lists')->where('todo_id', $todo_id)->update( $data );

            $data['todo_id'] = $todo_id;
            $data['human_date'] = human_date( date('Y-m-d H:i:s') );
            return response()->json(['success' => 'Record has been updated successfully!', $data, 'status' => 'success']);
        }
    }

    public function cancel_update_todo(Request $request) {
        if ( $request->ajax() ) {
            $todo_info = DB::table('todo_lists')->where('todo_id', $request->todo_id)->first();

            return response()->json( [$todo_info, 'human_date'=> human_date($todo_info->created_at), 'carbon_diff' => carbon_diff($todo_info->created_at) ] );
        }
    }

    public function delete_todo( Request $request, $todo_id) {
        if ( $request->ajax() ) {
            DB::table('todo_lists')->where('todo_id', $todo_id)->delete();

            return response()->json(['success' => 'Record has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the Todo', 'status' => 'failed']);
    }


    public function update_todo_sorting( Request $request ){
        if ( $request->ajax() ) {
            foreach ($request->sorting as $sorting) {
                DB::table('todo_lists')->where('todo_id', str_replace("todo-", "", $sorting['id']))->update( array( 'list_order' => $sorting['position'] ));
            }
            return response()->json(['success' => 'Record has been updated successfully!',$request->id => $request->sorting, 'status' => 'success']);
        }
        return response(['error' => 'Failed Todo sorting save', 'status' => 'failed']);
    }

    public function change_todo_status( Request $request ){
        if ( $request->ajax() ) {
            DB::table('todo_lists')->where('todo_id', $request->todo_id)->update( array( 'status' => $request->status ));
            return response()->json(['success' => 'Todo status changed to '.$request->status.' successfully!', 'status'=>$request->status]);
        }
        return response(['error' => 'Failed Todo sorting save', 'status' => 'failed']);
    }

    public function archive_todo( Request $request, $todo_id ){
        if ( $request->ajax() ) {
            DB::table('todo_lists')->where('todo_id', $todo_id)->update( array( 'archived_status' => "archived" ));
            return response()->json(['success' => 'Todo archived successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed Todo sorting save', 'status' => 'failed']);
    }
}
