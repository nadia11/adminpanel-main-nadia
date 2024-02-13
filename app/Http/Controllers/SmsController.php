<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class SmsController extends Controller
{
    private $SMS_SENDER_ID = "Esojai";
    private $MASKING_STATUS = "Masking";
    //private $SMS_SENDER_ID = "8809601001061";
    //private $MASKING_STATUS = "Non-Masking";
    //private $SMS_TYPE  = 'text';
    private $SMS_USERNAME = 'C2000085';
    private $SMS_PASSWORD = '0In2GPHQqP';
    private $API_KEY = 'C20000856085c9ce5b4456.32333811';
    private $API_URL = 'http://www.btssms.com/smsapi';

    public function sms_list()
    {
        $manage_sms = view('emails.sms-list');
        return view('dashboard')->with('main_content', $manage_sms);
    }

    public function sms_list_data(Request $request)
    {
        $datatable_query = DB::table('sms')->orderBy('created_at', 'DESC');

        $totalData = $datatable_query->count();
        $totalFiltered = $totalData;
        $start = $request->input('start');
        $limit = $request->input('length'); //Rows display per page filter
        $columnIndex = $request['order'][0]['column']; //Column index dynamic
        $order = $request['columns'][$columnIndex]['data']; //Column name dynamic
        $dir = $request->input('order.0.dir'); //asc or desc
        $search_value = $request['search']['value']; //$request->input('search.value');


        /*************user_filter_from_url************/
        if ($request->phone_prefix_filter) {
            $datatable_query->where('sms_prefix', $request->phone_prefix_filter)->get();
            $totalFiltered = $datatable_query->count();
        }
        if ($request->recipient_filter) {
            $datatable_query->where('receiver', $request->recipient_filter)->get();
            $totalFiltered = $datatable_query->count();
        }

        if (isset($request['search']) && $search_value != '') {
            $datatable_query->where('subject', 'LIKE', "%{$search_value}%")
                ->orWhere('sender', 'LIKE', "%{$search_value}%")
                ->orWhere('receiver', 'LIKE', "%{$search_value}%")
                ->orWhere('sent_time', 'LIKE', "%{$search_value}%")
                ->orWhere('status', 'LIKE', "%{$search_value}%")
                ->get();

            $totalFiltered = $datatable_query->count();
        }

        if (isset($request['order']) && count($request['order'])) {
            $datatable_query->orderBy($order, $dir)->get();
        }

        /******* 1 lac pcs********/
        if (isset($request['start']) && $request['length'] === 1000000) {
            $datatable_query->offset($request['start'])->limit($request['length'])->get();
        }

        /*******Total number of records without filtering*****/
        $table_generate_data = $datatable_query->offset($start)->limit($limit)->orderBy($order, $dir)->get();

        $data = array();
        if (!empty($table_generate_data)) {
            foreach ($table_generate_data as $key => $row) {
                //$nestedData['DT_RowClass'] = "row_".$row->sms_id;
                $nestedData['sms_id'] = $key + 1 + $start; /*Index Column*/
                $nestedData['trx_id'] = $row->trx_id;
                $nestedData['subject'] = $row->subject ?? "-";
                $nestedData['sender'] = $row->sender ?? "-";
                $nestedData['receiver'] = slug_to_title($row->receiver) ?? "-";
                $nestedData['sent_time'] = $row->sent_time ? date('d/m/Y h:m:s A', strtotime($row->sent_time)) : "-";
                $nestedData['status'] = str_snack($row->status) ?? "-";

                $nestedData['action'] = '<button type="button" class="btn btn-info btn-sm viewSMS" id="' . $row->sms_id . '"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                $nestedData['action'] .= '<button type="button" class="btn btn-danger btn-sm ajaxDelete" data-href="' . url("/notification/delete-sms/" . $row->sms_id) . '" data-title="' . $row->subject . '" id="' . $row->sms_id . '"><i class="fa fa-trash" aria-hidden="true"></i></button>';

                //Final data
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => isset($request['draw']) ? intval($request->input('draw')) : 0,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        return response()->json($json_data);
    }

    public function view_sms(Request $request, $sms_id)
    {
        if ($request->ajax()) {
            $view_sms = DB::table('sms')
                ->join('users', 'sms.user_id', '=', 'users.id')
                ->select('sms.*', 'users.name as user_name')
                ->where('sms.sms_id', $sms_id)->first();
            return response()->json(array($view_sms));
        }
    }

    public function delete_sms(Request $request, $sms_id)
    {
        if ($request->ajax()) {
            DB::table('sms')->where('sms_id', $sms_id)->delete();
            return response()->json(['success' => 'SMS has been deleted successfully!', 'status' => 'success']);
        }
        return response(['error' => 'Failed deleting the SMS', 'status' => 'failed']);
    }

    public function send_sms(Request $request)
    {
        $phone_number = $request->input('phone_number');
        $message_body = $request->input('message_body');
        $sms_type = $request->input('sms_type');
        $success_message = "A message has been sent to you";
        $sent_sms = 0;

        if ($request->recipient_type == "group_recipient") {
            //$this->send_sms_to_group($sms_type, $message_body, $request->contact_group);
        } else {
            $sent_sms = $this->SMSThroughCurl($sms_type, $phone_number, $message_body);
            //$sent_sms = $this->SMSThroughGuzzle($sms_type, $phone_number, $message_body);
        }
        //dd($request->all());


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

        $trx_id = $sent_sms == 0 ? 0 : explode(' ', $sent_sms['message'][4]);
        //$trx_id = str_replace("SMS SUBMITTED: ID - ", "", $sent_sms['message']);
        $status = $sent_sms !== '' ? (array_key_exists($trx_id, $message_status_array) ? $message_status_array[$sent_sms['message']] : 'Delivered') : "Multiple ID";

        if ($request->ajax()) {
            //$this->initiateSmsGuzzle($phone_number, $message);

            //$validatedData = $request->validate([
            //    'title' => 'required|unique:posts|max:255',
            //    'body' => 'required',
            //]);

            /**Save sent Message to Database**/
            $data = array(
                'trx_id' => $trx_id,
                'status' => $status,
                'sms_prefix' => "",
                //'sms_prefix'     => $request->recipient_type == "single_recipient" ? $operators[substr($request->phone_number, 0, 5)] : "",
                'masking_status' => $this->MASKING_STATUS,
                'sender' => $this->SMS_SENDER_ID,
                'receiver' => $request->recipient_type == "single_recipient" ? $request->phone_number : $request->contact_group,
                'sent_time' => date('Y-m-d H:i:s'),
                'subject' => $request->subject,
                'message_body' => $request->message_body,
                'sms_type' => $request->sms_type,
                'user_id' => Auth::id(),
                'created_at' => date('Y-m-d H:i:s'),
            );
            DB::table('sms')->insert($data);

            return response()->json([
                'success' => 'Message has been sent successfully!',
                'status' => 'success',
                $data
            ]);
        }
        return response(['error' => 'Failed saving the sms', 'status' => 'failed']);
    }


    function SMSThroughGuzzle($sms_type, $phone_number, $message)
    {
        $operatorResponse = '';
        $sms_status = '';
        $transactionId = '';

        $client = new \GuzzleHttp\Client();
        $httpRequest = $client->get($this->API_URL . '?api_key=' . urlencode($this->API_KEY) . "&type=text&contacts=" . $phone_number . "&senderid=" . $this->SMS_SENDER_ID . "&msg=" . $message);

        if ($httpRequest->getStatusCode() === 200) {
            $operatorResponse = "OK";
            //$httpResponse = $httpRequest->getBody();
            //dd($httpRequest->getReasonPhrase());
            //dd($httpRequest->->getHeaderLine('content-type'));
            //$httpResult = json_decode($httpResponse);

            //if(!empty($httpResponse)) {
            //    if(json_decode($httpResponse)->code == 1) {
            //        $operatorResponse = json_decode($httpResponse)->desc;
            //    }
            //}
            //else {
            //    $operatorResponse = $httpRequest->getReasonPhrase();
            //}
        }

        //if($operator_short_code == 'GP' && $apiStatus == 1)
        //{
        //    $httpResult = json_decode($operatorResponse);
        //    $getResponseValue = explode(' ', $httpResult->resp);
        //
        //    if(!empty($getResponseValue[11]))
        //    {
        //        $operatorTransactionID = $getResponseValue[11];
        //        $data['transaction'] = $operatorTransactionID;
        //        $transactionId = $operatorTransactionID;
        //        $recharge_status = 'SUCCESS';
        //    }
        //}

        //STORE INBOX FLASH MESSAGE
        if ($operatorResponse <> 'timeout') {
            $flashData['message'] = $operatorResponse;
            $flashData['action_dt_time'] = date('Y-m-d H:i:s');
            $flashData['created_at'] = date('Y-m-d H:i:s');
            $flashData['message_status'] = 'Success';
            $flashData['type'] = 'FLASH';
        }

        return $response = ['operatorResponse' => $operatorResponse, 'sms_status' => $sms_status, 'TransactionID' => $transactionId];
    }


    public function SMSThroughCurl($sms_type, $phone_number, $message)
    {
        $isError = 0;
        $errorMessage = true;

        $data = array(
            'api_key' => urlencode($this->API_KEY),
            'type' => $sms_type,
            'contacts' => $phone_number,
            'senderid' => $this->SMS_SENDER_ID,
            'msg' => $message,
        );

        //Reference: https://www.php.net/manual/en/book.curl.php  &&& http://docs.guzzlephp.org/en/stable/
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->API_URL);
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type:application/json", "Accept:application/json"));
        //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        //curl_setopt($ch, CURLOPT_USERPWD, $this->SMS_USERNAME .":". $this->SMS_PASSWORD);


        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);


        //curl_setopt_array($ch, array(
        //    CURLOPT_URL => $this->API_URL,
        //    CURLOPT_RETURNTRANSFER => true,
        //    CURLOPT_POST => true,
        //    CURLOPT_POSTFIELDS => $data
        //));

        /**Ignore SSL certificate verification**/
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


        $response = curl_exec($ch);
        //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }

        if ($isError) {
            return array('error' => 1, 'message' => $errorMessage);
        } else {
            return array('succes' => 1, 'message' => $response);
        }

        curl_close($ch);
        return $response;
    }


    public function initiateSmsGuzzle0000($phone_number, $message)
    {
        $client = new Client();

        //$response = $client->post('http://portal.bulksmsnigeria.net/api/?', [
        $response = $client->post($this->API_URL . '?api_key=' . $this->API_KEY, [
            'verify' => false,
            'form_params' => [
                'username' => $this->SMS_USERNAME,
                'password' => $this->SMS_PASSWORD,
                'message' => $message,
                'sender' => $this->SMS_SENDER_ID,
                'mobiles' => $phone_number,
            ],
        ]);
        $response = json_decode($response->getBody(), true);
    }

    public function send_sms_to_group($sms_type, $message_body, $contact_group)
    {

        if ($contact_group == 'all-riders' || $contact_group == 'all-drivers' || $contact_group == 'all-agents') {

            if ($contact_group == 'all-riders') {
                $all_riders = DB::table('riders')->pluck('mobile');
                foreach ($all_riders as $rider_mobile) {
                    $this->SMSThroughGuzzle($sms_type, $rider_mobile, $message_body);
                }
            }

            if ($contact_group == 'all-drivers') {
                $all_drivers = DB::table('drivers')->pluck('mobile');
                foreach ($all_drivers as $driver_mobile) {
                    $this->SMSThroughGuzzle($sms_type, $driver_mobile, $message_body);
                }
            }

            if ($contact_group == 'all-agents') {
                $all_agents = DB::table('agents')->pluck('mobile');
                foreach ($all_agents as $agent_mobile) {
                    $this->SMSThroughGuzzle($sms_type, $agent_mobile, $message_body);
                }
            }
        } else {
            $all_contacts = DB::table('contacts')->where('group_id', $contact_group)->pluck('contact_mobile');
            foreach ($all_contacts as $contact_mobile) {
                $this->SMSThroughGuzzle($sms_type, $contact_mobile, $message_body);
            }
        }
    }


    public function nexmoSms(Request $request)
    {
        Log::info($request);


        try {
            //             $curl = curl_init();

            //             curl_setopt_array(
//                 $curl,
//                 array(
//                     CURLOPT_URL => 'https://api.d7networks.com/verify/v1/otp/send-otp',
//                     CURLOPT_RETURNTRANSFER => true,
//                     CURLOPT_ENCODING => '',
//                     CURLOPT_MAXREDIRS => 10,
//                     CURLOPT_TIMEOUT => 0,
//                     CURLOPT_FOLLOWLOCATION => true,
//                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                     CURLOPT_CUSTOMREQUEST => 'POST',
//                     CURLOPT_POSTFIELDS => '{
//     "originator": "SignOTP",
//     "recipient": "+8801752015791",
//     "content": "Greetings from D7 API, your mobile verification code is: {}",
//     "expiry": "600",
//     "data_coding": "text"
// }',
//                     CURLOPT_HTTPHEADER => array(
//                         'Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhdWQiOiJhdXRoLWJhY2tlbmQ6YXBwIiwic3ViIjoiZTUwYmFmNTMtZjEwOS00MGVkLWFjMjAtNjBmOWY0NGE5MmQ4In0.-Wbi5IlgGC1GuT817ZLWL7iQ6rkCWp5LVEMttq-Efec',
//                         'Content-Type: application/json'
//                     ),
//                 )
//             );

            //             $response = curl_exec($curl);

            //             curl_close($curl);
//             Log::info($response);
        } catch (\Exception $e) {
            // Log the error
            $errorMessage = 'An error occurred while sending SMS: ' . $e->getMessage();
            echo $errorMessage;
            Log::error('Error sending sms', [
                'error' => $e->getMessage()
            ]);
            // Return a generic error response
            return response()->json(['error' => $errorMessage], 500);
        }
    }
}
