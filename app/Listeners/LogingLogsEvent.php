<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Http\Request;



class LogingLogsEvent
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $login_data = array(
            'user_id'=>$event->user->id,
            'login_ip'     => \Illuminate\Support\Facades\Request::ip(),
            'login_time'   => Carbon::now()->toDateTimeString(),
            //'agent_os'   =>  (strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') ? 'Windows' : ""),
            'agent_os'   =>  getBrowser()['platform'],
            'user_agent'   => getBrowser()['name'] ." ". getBrowser()['version'], /*get_browser_name()*/
            'created_at'   => date('Y-m-d H:i:s')
        );
        DB::table('login_logs')->insert( $login_data );;
    }
}
