<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;


class EmailController extends Controller
{
    public function inbox() {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_type', 'inbox')->get();
        $manage_bank = view('emails.inbox')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function sent() {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_type', 'sent')->get();
        $email_page = view('emails.email-sent')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function compose() {
        $manage_bank = view('emails.email-compose');
        return view('dashboard')->with('main_content', $manage_bank);
    }

    public function send_email(Request $request) {
//        dd($request->file('attachment')->getMimeType());
        $validatedData = $request->validate([
            'recipients' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10',
            'attachment' => 'mimes:jpeg,jpg,png,gif,svg,txt,pdf,ppt,docx,xls',
        ]);
        $data = array(
            'from'       => settings('company_email'),
            'to'         => $request->recipients,
            'cc'         => $request->cc,
            'bcc'        => $request->bcc,
            'email_date' => date('Y-m-d H:i:s'),
            'subject'    => $request->subject,
            'message'    => $request->message,
            'attachment' => $request->file('attachment'),
            'email_type' => 'sent',
            'email_status' => 'read',
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('emails')->insert( $data );

        //Mail::to( Auth::user()->email )->send(new DemoMail());
        //Mail::to( $request->recipients )->cc($request->cc)->bcc($request->bcc)->send(new sendEmail($data));


        // maximum allowed file size
        //if ($document->getError() == 1) {
        //    $max_size = $document->getMaxFileSize() / 1024 / 1024;  // Get size in Mb
        //    $error = 'The document size must be less than ' . $max_size . 'Mb.';
        //    return redirect()->back()->with('flash_danger', $error);
        //}

        /*
        Mail::send('emails.template-send', $data, function($message) use ($data){
            //$message->from(env('ADMIN_EMAIL'), 'Virat Gandhi');
            $message->from( $data['from'] );
            $message->to( $data['to']);
            if (isset($data['cc'])) { $message->cc( $data['cc'] ); }
            if (isset($data['bcc'])) { $message->bcc( $data['bcc'] ); }
            $message->subject( $data['subject'] );
            if (isset($data['attachment'])) {
                $message->attach( $data['attachment']->getRealPath(), ['as' => $data['attachment']->getClientOriginalName(), 'mime' => $data['attachment']->getMimeType()] );
            }
//            $message->greeting(sprintf('Hello %s', $user->name));
//            $message->line('You have successfully registered to our system. Please activate your account.');
//            $message->action('Click Here', route('activate.user', $user->activation_code));
//            $message->line('Thank you for using our application!');
        });
*/


//        if( count(Mail::failures()) > 0 ) {
//            return 'Something went wrong!' ;
//        }

        return redirect('/email/sent')->with('success', 'Email has been sent successfully!');
    }

//    public function pending_bill_email(Request $request) {
//        $validatedData = $request->validate([
//            'recipients' => 'required|email',
//            'subject' => 'min:3',
//            'message' => 'min:10',
//            'attachment' => 'mimes:jpeg,jpg,png,gif,svg,txt,pdf,ppt,docx,xls',
//        ]);
//        $data = array(
//            'from'       => settings('company_email'),
//            'to'         => $request->recipients,
//            'cc'         => $request->cc,
//            'bcc'        => $request->bcc,
//            'email_date' => date('Y-m-d H:i:s'),
//            'subject'    => $request->subject,
//            'message'    => $request->message,
//            'attachment' => $request->attachment,
//            'email_type' => 'sent',
//            'created_at' => date('Y-m-d H:i:s'),
//        );
//        DB::table('emails')->insert( $data );
//
//
//        Mail::send('emails.email-template', $data, function($message) use ($data){
//            //$message->from(env('ADMIN_EMAIL'));
//            $message->from(settings('company_email'));
//            $message->to( $data['to'] );
//            //$message->cc( $data['cc'] );
//            //$message->bcc( $data['bcc'] );
//            $message->subject( $data['subject'] );
//            $message->sender('email@example.com', 'Mr. Example');
//            $message->returnPath('email@example.com');
//            $message->cc('email@example.com', 'Mr. Example');
//            //$message->greeting(sprintf('Hello %s', $user->name));
//            $message->replyTo('email@example.com', 'Mr. Example');
//            $message->priority(2);
//            //$message->line('You have successfully registered to our system. Please activate your account.');
//            //$message->action('Click Here', route('activate.user', $user->activation_code));
//            //$message->line('Thank you for using our application!');
//        });
//
//        //$manage_bank = view('emails.inbox');
//        //return view('dashboard')->with('main_content', $manage_bank);
//        return redirect('/email/sent')->with('success', 'Email was sent Successfully!');
//    }

    public function drafts(Request $request) {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_type', 'drafts')->get();
        $email_page = view('emails.email-drafts')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function drafts_save(Request $request) {
        $data = array(
            'from'       => settings('company_email'),
            'to'         => $request->recipients,
            'cc'         => $request->cc,
            'bcc'        => $request->bcc,
            'email_date' => date('Y-m-d H:i:s'),
            'subject'    => $request->subject,
            'message'    => $request->message,
            'attachment' => $request->file('attachment'),
            'email_type' => 'drafts',
            'email_status' => 'read',
            'created_at' => date('Y-m-d H:i:s'),
        );
        DB::table('emails')->insert( $data );
        //return response($data, 200)->header('Content-Type', 'text/plain');
        return response()->json(['message' => 'Email saved as draft']);
    }

    public function spam() {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_type', 'spam')->get();
        $email_page = view('emails.email-spam')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function starred() {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_attribute', 'starred')->get();
        $email_page = view('emails.email-starred')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function change_email_status(Request $request, $email_id, $email_status) {
        if ( $request->ajax() ) {
            DB::table('emails')->where('email_id', $email_id)->update(['email_status'=>$email_status]);
            return response()->json(['message' => 'Email status has been changed successfully!', 'email_id'=>$email_id, 'email_status'=>$email_status]);
        }
        return response(['message' => 'Failed to change email status']);
    }

    public function set_email_star(Request $request, $email_id, $attribute) {
        if ( $request->ajax() ) {
            DB::table('emails')->where('email_id', $email_id)->update(['email_attribute'=> ($attribute == 'Starred' ? 'Not starred' : 'Starred') ]);
            return response()->json(['message' => 'Email status has been changed successfully!', 'email_id'=>$email_id, 'attribute'=>$attribute]);
        }
        return response(['message' => 'Failed to change email status']);
    }

    public function request_view_email(Request $request, $email_id) {
        if ( $request->ajax() ) {
            return response()->json(['message' => 'Email has been deleted successfully!', 'view_url'=> url('/email/view/' . base64_encode('salturl'. $email_id. 'salturl')) ]);
        }
        return response(['message' => 'Failed deleting the Entry']);
    }

    public function view_email(Request $request, $email_id) {
        $email_id = str_replace('salturl', "", base64_decode($email_id));

        DB::table('emails')->where('email_id', $email_id)->update(['email_status'=>"read"]);

        $email_data = DB::table('emails')->where('email_id', $email_id)->first();
        $email_page = view('emails.view-email')->with('email_data', $email_data)->with('a', $email_id);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function soft_delete(Request $request) {
        if ( $request->ajax() ) {
            DB::table('emails')->where('email_id', $request->email_id)->update(['email_type' => 'trash']);
            return response()->json(['message' => 'Email has been deleted successfully!']);
        }
        return response(['message' => 'Failed deleting the Entry']);
    }

    public function trash() {
        $email_data = DB::table('emails')->orderBy('email_date', 'DESC')->where('email_type', 'trash')->get();
        $email_page = view('emails.email-trash')->with('email_data', $email_data);

        return view('dashboard')->with('main_content', $email_page);
    }

    public function empty_trash(Request $request) {
        if ( $request->ajax() ) {
            DB::table('emails')->where('email_type', 'trash')->delete();
            return response()->json(['message' => 'Trash has been empty successfully!']);
        }
        return response(['message' => 'Failed empty the Trash']);
    }
}
