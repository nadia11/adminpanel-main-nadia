<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\ChatEvent;


class ChatMessageController extends Controller
{
    public function chat_room($user_name = null)
    {
        $users = DB::table('users')->where('name', $user_name)->select('id', 'photo', 'role_id')->first();
        $role_name = DB::table('user_roles')->where('role_id', isset($users) ? $users->role_id : "")->value('role_name');
        $contact_lists = DB::table('chat_contacts')->leftJoin('users', 'chat_contacts.user_id', '=', 'users.id')->where('receipent_id', Auth::id())->whereNotIn('users.id', array(Auth::id()))->select('chat_contacts.*', 'users.name', 'users.id', 'users.photo')->get();



        /**************/
        $joined_ids = array(Auth::id());
        $contact_ids = DB::table('chat_contacts')->where('user_id', array(Auth::id()))->pluck('receipent_id');
        foreach ($contact_ids as $id) { $joined_ids[] = $id; }

        $max = DB::table('chat_messages')->whereIn('sender_id', $joined_ids)->orderBy('created_at', 'DESC')->max('created_at');
        $last_messages = DB::table('chat_messages')->whereIn('sender_id', $joined_ids)->where('created_at', $max)->value('conversation_id');
        /**************/


        $conversations = DB::table('chat_contacts')->where('user_id', (isset($users) ? $users->id : "0"))->where('receipent_id', Auth::id())->select('chat_contact_id', 'conversation_id', 'star_status')->first();
        $conversation_id = isset($conversations) ? $conversations->conversation_id : "0";
        $chat_contact_id = isset($conversations) ? $conversations->chat_contact_id : "0";
        $star_status = isset($conversations) ? $conversations->star_status : "";

        $query = DB::table('chat_messages')->join('users', 'chat_messages.sender_id', 'users.id')->where('conversation_id', $conversation_id)->select('chat_messages.*', 'users.name', 'users.photo');
        $message_count = $query->count();
        $message_lists = $query->skip($message_count-10)->limit(10)->get();

        //Change as read
        if($user_name){ DB::table('chat_messages')->whereNotIn('sender_id', array(Auth::id()))->where('conversation_id', $conversation_id)->update(['reading_status'=>"read"]); }

        $chat_page = view('includes.chat-message')->with(['user_id'=> (isset($users) ? $users->id : "0"), 'username'=>$user_name, 'user_photo'=>(isset($users) ? $users->photo : "0"), 'role_name'=>$role_name, 'message_lists'=>$message_lists, 'contact_lists'=>$contact_lists, 'chat_contact_id'=>$chat_contact_id, 'conversation_id'=>$conversation_id, 'star_status'=>$star_status, 'last_messages'=>$last_messages]);

        return view('dashboard')->with('main_content', $chat_page);
    }

    public function send_message(Request $request)
    {

        //Push Notification
        $user = Auth::id();
        $message = "Hello World";
        event(new ChatEvent($request->message_body, $request->conversation_id));

        return redirect('message/developer');
    }

//    public function send_message( Request $request)
//    {
//        //Push Notification
//        $user = Auth::id();
//        $message = "Hello World";
//        event(new ChatEvent($message));
//
//        if ( $request->ajax() ) {
//            $data = array(
//                'sender_id'       => Auth::id(),
//                'conversation_id' =>$request->conversation_id,
//                'message_body'    => $request->message_body,
//                //'message_type'  => "",
//                'reading_status'   => 'unread',
//                'created_at'      => date('Y-m-d H:i:s'),
//            );
//            $insert_id = DB::table('chat_messages')->insertGetId( $data );
//            $message_time = Carbon::createFromFormat('Y-m-d H:i:s', $data['created_at'] )->format('g:i A, l');
//            $photo = DB::table('users')->where('id', Auth::id())->value('photo');
//            $photo_url = !empty($photo) ? public_url( "user-photo/". $photo ) : image_url('defaultAvatar.jpg');
//
//            return response()->json( array( $data, 'message'=>'Message Sent Successfully!', compact( 'insert_id', 'message_time', 'photo_url') ));
//        }
//        return response(['message' => 'Failed to save Cash Receive']);
//    }

    public function add_chat_contact( Request $request, $chat_contact_id)
    {
        if ( $request->ajax() )
        {
            $conversation_id = DB::table('conversations')->insertGetId(
                array(
                    'sender_id'    => Auth::id(),
                    'receipent_id' => $chat_contact_id,
                    'status'       => 0,
                    'created_at'   => date('Y-m-d H:i:s'),
                )
            );

            $data1 = array(
                'user_id'          => Auth::id(),
                'receipent_id'     => $chat_contact_id,
                'conversation_id'  => $conversation_id,
                'star_status'      => "NotStarred",
                'archive_status'   => "NotArchive",
                'spam_status'      => "NotSpam",
                //'reading_status' => "unread",
                'block_status'     => "unblock",
                'created_at'       => date('Y-m-d H:i:s'),
            );
            $data2 = array(
                'user_id'          => $chat_contact_id,
                'receipent_id'     => Auth::id(),
                'conversation_id'  => $conversation_id,
                'star_status'      => "NotStarred",
                'archive_status'   => "NotArchive",
                'spam_status'      => "NotSpam",
                //'reading_status'   => "unread",
                'block_status'     => "unblock",
                'created_at'       => date('Y-m-d H:i:s'),
            );
            DB::table('chat_contacts')->insert( [$data1,  $data2]);

            return response()->json( array( 'message'=>'Message Sent Successfully!' ));
        }
        return response(['message' => 'Failed to save Cash Receive']);
    }

    public function delete_chat_contact( Request $request) {
        if ( $request->ajax() ) {
            $conversation_id = DB::table('chat_contacts')->where('chat_contact_id', $request->chat_contact_id)->value('conversation_id');

            $chat_contact_ids = DB::table('chat_contacts')->where('conversation_id', $conversation_id)->select('chat_contact_id')->get();
            foreach($chat_contact_ids as $chat_contact_id){
                DB::table('chat_contacts')->where('chat_contact_id', $chat_contact_id->chat_contact_id)->delete();
            }

            $chat_message_ids = DB::table('chat_messages')->where('conversation_id', $conversation_id)->select('chat_message_id')->get();
            foreach($chat_message_ids as $chat_message_id){
                DB::table('chat_messages')->where('chat_message_id', $chat_message_id->chat_message_id)->delete();
            }
            return response()->json(['message' => 'Chat Message has been deleted successfully!']);
        }
        return response(['message' => 'Failed deleting the Bank Account']);
    }

    public function change_reading_status(Request $request, $chat_contact_id, $reading_status) {
        if ( $request->ajax() ) {
            $conversation_id = DB::table('chat_contacts')->where('chat_contact_id', $chat_contact_id)->value('conversation_id');
            $chat_message_id = DB::table('chat_messages')->where('conversation_id', $conversation_id)->latest()->value('chat_message_id');

            DB::table('chat_messages')->where('chat_message_id', $chat_message_id)->whereNotIn('sender_id', array(Auth::id()))->update(['reading_status'=> ($reading_status == "read"?"unread":"read")]);
            return response()->json(['message' => 'Message status has been changed successfully!']);
        }
        return response(['message' => 'Failed to change email status']);
    }

    public function block_chat_contact(Request $request, $chat_contact_id) {
        if ( $request->ajax() ) {
            DB::table('chat_contacts')->where('chat_contact_id', $chat_contact_id)->update(['block_status'=>"block"]);
            return response()->json(['message' => 'Contact has been blocked successfully!']);
        }
        return response(['message' => 'Failed to block Contact']);
    }

    public function change_star_status(Request $request, $chat_contact_id, $status) {
        if ( $request->ajax() ) {
            DB::table('chat_contacts')->where('chat_contact_id', $chat_contact_id)->update(['star_status'=> ($status == 'Starred' ? 'NotStarred' : 'Starred') ]);
            return response()->json(['message' => 'Email status has been changed successfully!', 'chat_contact_id'=>$chat_contact_id, 'star_status'=>$status]);
        }
        return response(['message' => 'Failed to change email status']);
    }

//    public function delete_chat_histry( Request $request) {
//        if ( $request->ajax() ) {
//            DB::table('chat_messages')->where('chat_message_id', $request->chat_message_id)->delete();
//            return response()->json(['message' => 'Chat Message has been deleted successfully!']);
//        }
//        return response(['message' => 'Failed deleting the Bank Account']);
//    }
}
