<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DB;


class NotificationController extends Controller
{
    public function notification_list()
    {
        $notification_info = DB::table('notifications')->get();
        $manage_notification = view('emails.notification-list')->with('notification_info', $notification_info);

        return view('dashboard')->with('main_content', $manage_notification);
    }


    public function new_notification_save( Request $request)
    {
        //dd($request->all());
        //$validatedData = $request->validate([
        //    'title' => 'required|unique:notifications|max:255',
        //    'body' => 'required',
        //]);

        $data = array(
            'notification_title' => $request->notification_title,
            'notification_body'  => $request->notification_body,
            'notification_icon'  => $request->notification_icon,
            'notification_url'   => $request->notification_url,
            'recipient'          => $request->recipient,
            'platform'           => $request->platform,
            'type'               => $request->notification_type,
            'status'             => 'sent',
            'read_at'            => date('Y-m-d H:i:s'),
            'created_at'         => date('Y-m-d H:i:s'),
        );

        if($request->recipient == 'all-riders') {
            $fcm_tokens = DB::table('notification_devices')->where('device_user_type', 'rider')->select('device_user_type', 'fcm_token')->get();

            foreach ($fcm_tokens AS $token) {
                $this->send_push_notification_android_curl($token->fcm_token, $request->notification_title, $request->notification_body);
                $data['recipient_qty'] = count($fcm_tokens);
            }
        }

        if($request->recipient == 'all-drivers') {
            $fcm_tokens = DB::table('notification_devices')->where('device_user_type', 'driver')->select('device_user_type', 'fcm_token')->get();

            foreach ($fcm_tokens AS $token) {
                $this->send_push_notification_android_curl($token->fcm_token, $request->notification_title, $request->notification_body);
                $data['recipient_qty'] = count($fcm_tokens);
            }
        }

        if($request->recipient == 'all-agents') {
            $fcm_tokens = DB::table('notification_devices')->where('device_user_type', 'agents')->select('device_user_type', 'fcm_token')->get();

            foreach ($fcm_tokens AS $token) {
                $this->send_push_notification_android_curl($token->fcm_token, $request->notification_title, $request->notification_body);
                $data['recipient_qty'] = count($fcm_tokens);
            }
        }

        //Save to Database
        DB::table('notifications')->insert( $data );

        return redirect('/notification/notification-list')->with('success', 'Created New Notification Successfully!');
    }


    public function view_notification( Request $request, $notification_id )
    {
        if ( $request->ajax() ) {
            $view_notification = DB::table('notifications')->where('notification_id', $notification_id )->first();
            return response()->json( array( $view_notification) );
        }
    }


    public function delete_notification( Request $request, $notification_id)
    {
        if ( $request->ajax() ) {
            DB::table('notifications')->where('notification_id', $notification_id)->delete();
            return response()->json(['success' => 'notification has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the notification', 'status' => 'failed']);
    }


    public function get_all_tokens() {
        $fcm_tokens = DB::table('notification_devices')->select('fcm_token')->get();

        $tokens = array();
        foreach ($fcm_tokens AS $token) {
            array_push($tokens, $token->fcm_token);
        }
        return $tokens;
    }

    public function get_token_by_mobile($mobile) {
        $fcm_tokens = DB::table('notification_devices')->where('mobile', $mobile)->value('fcm_token');
        return array($fcm_tokens);
    }

    public function send_push_notification_android_curl($fcm_token, $title, $message)
    {
        $server_key = 'AAAAZkrZYhE:APA91bHcVFZKUu7dOA0KakYXYKSZIcKT0PwuIot6wp0IUeegwTpoE_GeVZeqbnhUQzvBIi1rmlEN0mg-Wnea9xT61nOxhpFKkp7JJUO3mjQNyNOywoI4MkaP5eZbCpOBylWYcOvZqiVb';
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $headers = [ 'Authorization: key='.$server_key, 'Content-Type: application/json' ];

        $fields = array(
            //'registration_ids' => array($fcm_token),
            'to' => $fcm_token,
            'notification' => array(
				'title' => $title,
				'body' => $message,
                'image'  => url( "/images/logo-mini.png"),
                'sound' => 'default',
                'tag' => Carbon::now()->format('M d Y, h:i A')
			),
            'data' => [
                "date" => date('M d Y, H:i:s'),
                "extraMessage" => 'extra data',
                "moredata" =>'moredata'
            ]
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $response = curl_exec($ch);

        $errorMessage = curl_errno($ch) ? curl_error($ch) : "";
        curl_close($ch);
        return json_decode($response);
        //"{"multicast_id":5849677187517352372,"success":1,"failure":0,"canonical_ids":0,"results":[{"message_id":"0:1625426500996628%8e8135098e813509"}]}"
    }


    public function change_notification_status(Request $request) {
        if ( $request->ajax() ) {
            DB::table('notifications')
                ->where('notification_id', $request->notification_id)
                ->update( ['reading_status' => $request->reading_status ] );

            return response()->json([
                'success' => 'Notification Status changed successfully!',
                'status' => 'success',
                'reading_status' => $request->reading_status,
                'notification_id'=>$request->notification_id
            ]);
        }
    }
}
