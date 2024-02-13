<?php

namespace App\CustomClass;

use Illuminate\Http\Request;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class Sms {
    //Set in .env file
    //SMS_SENDER_ID  = ""
    //MASKING_STATUS = ""
    //SMS_TYPE       = ""
    //SMS_USERNAME   = ""
    //SMS_PASSWORD   = ""
    //API_KEY        = ""
    //API_URL        = ""

//    private static $SMS_SENDER_ID;
//    private static $MASKING_STATUS;
//    private static $SMS_TYPE;
//    private static $SMS_USERNAME;
//    private static $SMS_PASSWORD;
//    private static $API_KEY;
//    private static $API_URL;

    public static $SMS_SENDER_ID  = "Esojai";
    public static $MASKING_STATUS = "Masking"; //Masking, Non-Masking
    public static $SMS_TYPE       = "text";
    public static $SMS_USERNAME   = "";
    public static $SMS_PASSWORD   = "";
    public static $API_URL        = "http://www.btssms.com/smsapi";
    public static $API_KEY        = "C20000856085c9ce5b4456.32333811";

    public function __construct() {
        //$this->SMS_SENDER_ID  = env('SMS_SENDER_ID');
        //$this->MASKING_STATUS = env('MASKING_STATUS');
        //$this->SMS_TYPE       = env('SMS_TYPE');
        //$this->SMS_USERNAME   = env('SMS_USERNAME');
        //$this->SMS_PASSWORD   = env('SMS_PASSWORD');
        //$this->API_KEY        = env('SMS_KEY');
        //$this->API_URL        = env('API_URL');

        //self::$SMS_SENDER_ID  = "Esojai";
        //self::$MASKING_STATUS = "Masking"; //Masking, Non-Masking
        //self::$SMS_TYPE       = "text";
        //self::$SMS_USERNAME   = "";
        //self::$SMS_PASSWORD   = "";
        //self::$API_URL        = "http://www.btssms.com/smsapi";
        //self::$API_KEY        = "C20000855ef07d1a0c3bb6.30671475";
    }

    public static function send_sms($subject, $phone_number, $message_body, $sms_type='text'){
        //$phone_number = $request->input('phone_number');
        //$message_body = $request->input('message_body');
        //$sms_type     = $request->input('sms_type');
        $success_msg  = "Message has been sent to your Mobile successfully!";

        $sent_sms = self::SmsThroughCurl($sms_type, $phone_number, $message_body);
        //$this->SmsThroughApi($phone_number, $message_body);

        $operators = array(
            '88017' => 'GP - 017',
            '88013' => 'GP - 013',
            '88019' => 'BL - 019',
            '88014' => 'BL - 014',
            '88018' => 'Robi - 018',
            '88016' => 'Robi - 016',
            '88015' => 'Teletalk - 015'
        );
        $message_status_array = array(
            '1002' => "Sender Id/Masking Not Found",
            '1003' => "API Not Found",
            '1004' => "SPAM Detected",
            '1005' => "Internal Error",
            '1006' => "Internal Error",
            '1007' => "Balance Insufficient",
            '1008' => "Message is empty",
            '1009' => "Message Type Not Set (text/unicode)",
            '1010' => "Invalid User & Password",
            '1011' => "Invalid User Id"
        );
        $trx_id = str_replace("SMS SUBMITTED: ID - ", "", $sent_sms['message']);
        $status = array_key_exists($trx_id, $message_status_array) ? $message_status_array[$sent_sms['message']] : 'Delivered';

        if ( Request()->ajax() ) {
            //$validatedData = Request()->validate([
            //    'message_body' => 'required|unique:posts|max:500',
            //    'phone_number' => 'required',
            //]);

            /**Save sent Message to Database**/
            $data = array(
                'trx_id'         => $trx_id,
                'status'         => $status,
                'sms_prefix'     => $operators[substr($phone_number, 0, 5)],
                'masking_status' => self::$MASKING_STATUS,
                'sender'         => self::$SMS_SENDER_ID,
                'receiver'       => $phone_number,
                'sent_time'      => date('Y-m-d H:i:s'),
                'subject'        => $subject,
                'message_body'   => $message_body,
                'sms_type'       => $sms_type,
                'user_id'        => Auth::id(),
                'created_at'     => date('Y-m-d H:i:s'),
            );
            DB::table('sms')->insert( $data );
            return response()->json(['success' => $success_msg, 'status' => 'success', $data]);
        }
        return response(['error' => 'Failed saving the sms', 'status' => 'failed']);
    }


    public static function SmsThroughCurl($sms_type, $phone_number, $message){
        $isError = 0;
        $errorMessage = true;

        $data = array(
            'api_key'  => urlencode(self::$API_KEY),
            'type'     => $sms_type,
            'contacts' => $phone_number,
            'senderid' => self::$SMS_SENDER_ID,
            'msg'      => $message,
        );
        //dd($data);

        //Reference: https://www.php.net/manual/en/book.curl.php  &&& http://docs.guzzlephp.org/en/stable/
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, self::$API_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);

        //curl_setopt_array($ch, array(
        //    CURLOPT_URL => $this->API_URL,
        //    CURLOPT_RETURNTRANSFER => true,
        //    CURLOPT_POST => true,
        //    CURLOPT_POSTFIELDS => $data
        //));

        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Accept:application/json"));
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_USERPWD, $this->SMS_USERNAME .":". $this->SMS_PASSWORD);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);

        /**Ignore SSL certificate verification**/
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $response = curl_exec($ch);
        //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        if($isError){
            return array('error' => 1 , 'message' => $errorMessage);
        }else{
            return array('succes' => 1, 'message'=>$response );
        }

        curl_close($ch);
        return $response;
    }

    //http://portal.bulksmsnigeria.net
    public function SmsThroughApi($phone_number, $message){
        $client = new Client();

        $response = $client->post($this->API_URL .'?api_key='. $this->API_KEY, [
            'verify'    =>  false,
            'form_params' => [
                'username' => $this->SMS_USERNAME,
                'password' => $this->SMS_PASSWORD,
                'message' => $message,
                'sender' => $this->SMS_SENDER_ID,
                'mobiles' => $phone_number,
            ],
        ]);
        $response = json_decode($response->getBody(), true);
        return $response;
    }
}


//.......................
//use App\CustomClass\Sms;
//Sms::send_sms($api_token,'access login',json_encode($request->all()));
//.......................

//$sms = new Sms();
//$sendSms = $sms->send('01998369826');
