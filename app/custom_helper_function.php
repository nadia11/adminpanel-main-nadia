<?php
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
//use DB;


//Step 2: Add “app/helper.php” file path in the “composer.json”.-->
//<!--add "files": [ "app/custom_helper_function.php" ]
//after "psr-4": { "App\\": "app/" }-->
//<!--composer dump-autoload

//go back one directory dirname()
require_once( dirname(dirname(__FILE__)) . '/resources/views/user/user-manage-by-admin/generate-password.blade.php' );
//echo dirname($_SERVER["SCRIPT_FILENAME"]) . PHP_EOL;
//echo dirname(dirname(__FILE__)) . PHP_EOL;
//echo dirname(__FILE__) . PHP_EOL;
//echo basename(__FILE__) . PHP_EOL;
//dd($_SERVER);

if(!function_exists('weekdays')) {
  function weekdays() {
    return [
      'Mon' => 'Monday',
      'Tus' => 'Tuesday',
      'Wed' => 'Wednesday',
      'Thu' => 'Thursday',
      'Fri' => 'Friday',
      'Sat' => 'Saturday',
      'Sun' => 'Sunday'
    ];
  }
}
//uses: $weekdays = weekdays(); echo $weekdays['Mon'];

//echo '<script type="text/javascript">/*<![CDATA[*/ '.PHP_EOL.' var tits_project = {"url":"'. base_url() . '", "name":""}; '.PHP_EOL.' /*]]>*/ </script>' . PHP_EOL;
//echo ltrim(dirname( $_SERVER['PHP_SELF'] ), '/') . PHP_EOL;

function protocol () {
	$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://' ? 'https://' : 'http://';
    //$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
	return $protocol;
}

function base_url(){
    // output: /myproject/index.php
    $currentPath = $_SERVER['PHP_SELF'];

    // output: Array ( [dirname] => /myproject [basename] => index.php [extension] => php [filename] => index )
    $pathInfo = pathinfo($currentPath);

    // output: localhost
    $hostName = $_SERVER['HTTP_HOST'];

    // output: http://
    //$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https://' ? 'https://' : 'http://';
    //$protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $protocol = 'http://';

    // return: http://localhost/myproject/
    return $protocol . $hostName . $pathInfo['dirname'];
}
//echo base_url();

function public_url($url = null){
    $base_url = isset( $url ) ? ( "/public/" . $url ) : "/public";
    return base_url() . $base_url;
}
//echo public_url();


function upload_url($url = null){
    $upload_url = isset( $url ) ? ( "/storage/uploads/" . $url ) : "/storage/uploads/";
    return base_url() . $upload_url;
}

function upload_path($url = null){
    $upload_url = isset( $url ) ? ( "/storage/uploads/" . $url ) : "/storage/uploads/";
    return public_path() . $upload_url;
}

function storage_url($url = null){
    $upload_url = isset( $url ) ? ( "/storage/" . $url ) : "/storage/";
    return base_url() . $upload_url;
}

function image_url($url = null){
    $images_url = isset( $url ) ? ( "/images/" . $url ) : "/images";
    return base_url() . $images_url;
}

function get_gravatar( $email, $s = 80, $defaultImage = 'mp', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    //$url = 'http://2.gravatar.com/avatar/2ce24561ae650c2c64aa357f093f01a3'; default image

    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "&d=" . urlencode( $defaultImage );
    $url .= "?s=$s&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
    }
    return $url;
}


function unique_code($limit){
  return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
}
//echo unique_code(8);

function GENERATE_INVITATION_CODE($limit) {
    return strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit));
}

function get_mac_address(){
    system('ipconfig /all'); //Execute external program to display output
    $mycom=ob_get_contents(); // Capture the output into a variable
    ob_clean(); // Clean (erase) the output buffer
    $ipAddress=$_SERVER['REMOTE_ADDR'];
    $findme = "Physical";
    $pmac = strpos($mycom, $findme); // Find the position of Physical text
    $mac=substr($mycom,($pmac+36),17); // Get Physical Address*/

    return $mac;
    //echo $mac=substr(system('ipconfig /all'),(strpos(system('ipconfig /all'), "Physical")+36),17);
}

//dd($request->header('User-Agent'));
//dd($request->server('HTTP_USER_AGENT'));
//dd(system('getmac'));
//echo exec('getmac');

//function get_device(){
//    $useragent = $_SERVER['HTTP_USER_AGENT'];
//// get api token at https://www.useragentinfo.co/
//$token = "<api-token>";
//$url = "https://www.useragentinfo.co/api/v1/device/";
//
//$data = array('useragent' => $useragent);
//
//$headers = array();
//$headers[] = "Content-type: application/json";
//$headers[] = "Authorization: Token " . $token;
//
//$curl = curl_init($url);
//curl_setopt($curl, CURLOPT_HEADER, false);
//curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//curl_setopt($curl, CURLOPT_POST, true);
//curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//
//$json_response = curl_exec($curl);
//
//$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
//
//if ($status != 200 ) {
//    die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
//}
//
//curl_close($curl);
//
//echo $json_response;
//
//}

function get_device(){
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
    {
        return ('mobile device');
    }else{
        return ('Desktop/Laptop device');
    }
}

function get_browser_name(){
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    if (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR/')) return 'Opera';
    elseif (strpos($user_agent, 'Edge')) return 'Edge';
    elseif (strpos($user_agent, 'Chrome')) return 'Chrome';
    elseif (strpos($user_agent, 'Safari')) return 'Safari';
    elseif (strpos($user_agent, 'Firefox')) return 'Firefox';
    elseif (strpos($user_agent, 'MSIE') || strpos($user_agent, 'Trident/7')) return 'Internet Explorer';

    return 'Other';
}
//Usage: echo get_browser_name();


function str_snack($str){
    $sep = explode('_', $str);
    $a = implode(' ', $sep);
    return ucwords( $a );
}

function generateRandomString($length = 10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return strtoupper($randomString);
}

function slug_to_title($str){
    $sep = explode('-', $str);
    $a = implode(' ', $sep);
    return ucwords( $a );
}

function title_to_slug($str){
    $sep = explode(' ', $str);
    $a = implode('-', $sep);
    return Str::slug(strtolower( $a ));
}

//if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$_SERVER['HTTP_USER_AGENT'])||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($_SERVER['HTTP_USER_AGENT'],0,4))){echo "mobile";}else{echo "desktop";}
function isMobileDevice() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
//if(isMobileDevice()){ echo "It is a mobile device"; } else { echo "It is desktop or computer device"; }



function getBrowser(){
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    $ub= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) { $platform = 'linux'; }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) { $platform = 'mac'; }
    elseif (preg_match('/windows|win32/i', $u_agent)) { $platform = 'windows'; }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)){
        $bname = 'Internet Explorer'; $ub="MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent)){
        $bname = 'Mozilla Firefox'; $ub="Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent)){
        $bname = 'Google Chrome'; $ub="Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent)){
        $bname = 'Apple Safari'; $ub="Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent)){
        $bname = 'Opera'; $ub="Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent)){
        $bname = 'Netscape'; $ub="Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else { $version= $matches['version'][1]; }
    }
    else { $version= $matches['version'][0]; }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function get_days_between_two_dates($from_date){
    //Carbon::createFromDate(1975, 5, 21)->diffInDays(Carbon::today());
    $days = Carbon::createFromDate($from_date)->diffInDays(Carbon::today());
    return $days . " days left";

//    $to = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2017-5-6 3:30:10');
//    $from = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2017-5-6 3:35:35');
//    $diff_in_seconds = $to->diffInSeconds($from);
//    $diff_in_minutes = $to->diffInMinutes($from);
//    $diff_in_hours = $to->diffInHours($from);
}

function get_age( $date ){
    $age = Carbon::createFromFormat( 'Y-m-d', $date, 'Asia/Dhaka' )->diff(Carbon::now())->format('%y years, %m months and %d days');
    return $age;
}

function human_date( $date ){
    //$date = Carbon::createFromFormat( 'Y-m-d H:i:s', $date, 'Asia/Dhaka' )->diff(Carbon::now())->format('%y years, %m months and %d days') . " ago";
    //$date = Carbon::parse($date, 'Asia/Dhaka' )->diffForHumans();
    $date = Carbon::parse($date)->diffForHumans();
    return $date;
};

function carbon_date( $date ){
    //$date = Carbon::createFromFormat( 'Y-m-d H:i:s', $date )->diff(Carbon::now());
    //$sub = $date->sub( $date )->calendar();
    //$sub = $date->calendar();
    //$date = $first->greaterThanOrEqualTo($second);
    $sub = $date->diffInMinutes($date->copy()->addSeconds(59));
    return $sub;
};


function carbon_diff($date) {
    $dt = Carbon::parse($date);
    //$curDate = Carbon::now();

    if($dt->diffInMinutes() < 59){
        return $dt->diffInMinutes() < 59 ? "badge-danger" : "";
    }
    else if($dt->diffInHours() <= 23){
        return $dt->diffInHours() <= 23 ? "badge-info" : "";
    }
    else if($dt->diffInDays() == 1){
        return $dt->diffInDays() == 1 ? "badge-warning" : "";
    }
    else if($dt->diffInDays() <= 3){
        return $dt->diffInDays() <= 3 ? "badge-success" : "";
    }
    else if($dt->diffInDays() <= 7){
        return $dt->diffInDays() <= 7 ? "badge-primary" : "";
    }else{
        return "badge-secondary";
    }
}


function getAddress($latitude, $longitude, $api_key){
    if(!empty($latitude) && !empty($longitude)){
        $geocodeFromLatLong = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false&key='.$api_key);

        $output = json_decode($geocodeFromLatLong);
        $address = ($output->status == "OK") ? $output->results[1]->formatted_address : '';

//        $address = "";
//        if($status == "OK") {
//            $address .= $output->results[0]->address_components[1]->long_name;
//            $address .= $output->results[0]->address_components[2]->long_name;
//        }

        if(!empty($address)){ return $address; }else{ return false; }
    }else{
        return false;
    }
}

function getLatLong($address){
    if(!empty($address)){
        $formattedAddr = str_replace(' ','+',$address);
        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=GoogleAPIKey');
        $output = json_decode($geocodeFromAddr);
        $data['latitude']  = $output->results[0]->geometry->location->lat;
        $data['longitude'] = $output->results[0]->geometry->location->lng;
        if(!empty($data)){ return $data; }else{ return false; }
    }else{
        return false;
    }
}

//$latLong = getLatLong($address);
//$latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
//$longitude = $latLong['longitude']?$latLong['longitude']:'Not found';


function makecomma($input){
    if(strlen($input)<=2){ return $input; }

    $length=substr($input,0,strlen($input)-2);
    $formatted_input = makecomma($length) . "," . substr($input,-2);
    return $formatted_input;
}


function taka_format($symble, $num){
    $pos = strpos((string)$num, ".");
    if ($pos === false) { $decimalpart="00";}
    else { $decimalpart= substr($num, $pos+1, 2); $num = substr($num,0,$pos); }

    if(strlen($num)>3 & strlen($num) <= 12){
            $last3digits = substr($num, -3 );
            $numexceptlastdigits = substr($num, 0, -3 );
            $formatted = makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted.",".$last3digits.".".$decimalpart ;
    }
    elseif(strlen($num)<=3){
        $stringtoreturn = $num.".".$decimalpart ;
    }
    elseif(strlen($num)>12){
        $stringtoreturn = number_format($num, 2);
    }

    if(substr($stringtoreturn,0,2)=="-,"){$stringtoreturn = "-".substr($stringtoreturn,2 );}

    return $symble ? $symble . $stringtoreturn : $stringtoreturn;
}









//# Function to represent a number like '2nd', '10th', '101st' etc
//function text_number($n){
//    # Array holding the teen numbers. If the last 2 numbers of $n are in this array, then we'll add 'th' to the end of $n
//    $teen_array = array(11, 12, 13, 14, 15, 16, 17, 18, 19);
//
//    # Array holding all the single digit numbers. If the last number of $n, or if $n itself, is a key in this array, then we'll add that key's value to the end of $n
//    $single_array = array(1 => 'st', 2 => 'nd', 3 => 'rd', 4 => 'th', 5 => 'th', 6 => 'th', 7 => 'th', 8 => 'th', 9 => 'th', 0 => 'th');
//
//    # Store the last 2 digits of $n in order to check if it's a teen number.
//    $if_teen = substr($n, -2, 2);
//
//    # Store the last digit of $n in order to check if it's a teen number. If $n is a single digit, $single will simply equal $n.
//    $single = substr($n, -1, 1);
//
//    # If $if_teen is in array $teen_array, store $n with 'th' concantenated onto the end of it into $new_n
//    if ( in_array($if_teen, $teen_array) ){
//        $new_n = $n . 'th';
//    }
//    # $n is not a teen, so concant the appropriate value of it's $single_array key onto the end of $n and save it into $new_n
//    elseif ( $single_array[$single] ){
//        $new_n = $n . $single_array[$single];
//    }
//    return $new_n;
//}


function ordinal($num){
    // Special case "teenth"
    if ( ($num / 10) % 10 != 1 ) {
        // Handle 1st, 2nd, 3rd
        switch( $num % 10 )
        {
            case 1: return $num . 'st';
            case 2: return $num . 'nd';
            case 3: return $num . 'rd';
        }
    }
    // Everything else is "nth"
    return $num . 'th';
}



function bytes($a) {
    $unim = array("B","KB","MB","GB","TB","PB");
    $c = 0;
    while ($a>=1024) { $c++; $a = $a/1024; }
    return number_format($a,($c ? 2 : 0),".",".")." ".$unim[$c];
}

function formatBytes($size, $precision = 2){
    if ($size > 0) {
        $size = (int) $size;
        $base = log($size) / log(1024);
        $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

        return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
        return $size;
    }
}

function bytesToHuman($bytes){
    $units = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $bytes > 1024; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, 2) . ' ' . $units[$i];
}


//https://github.com/shrasel/taka-to-word-converter
require_once( dirname(dirname(__FILE__)) . '/resources/views/includes/WordConverter.class.php' );


function taka_in_words($number){
    //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
    $words = array('0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five', '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten', '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen', '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen', '18' => 'eighteen', '19' => 'nineteen','20'=>'twenty', '30' => 'thirty', '40' => 'fourty', '50' => 'fifty', '60' => 'sixty', '70' => 'seventy', '80' => 'eighty', '90' => 'ninty');

    $number_length = strlen($number);
    $number_array = array(0,0,0,0,0,0,0,0,0);
    $received_number_array = array();

    //Store all received numbers into an array
    for($i=0; $i<$number_length; $i++){
        $received_number_array[$i] = substr($number,$i,1);
    }

    //Populate the empty array with the numbers received - most critical operation
    for($i=9-$number_length, $j=0; $i<9; $i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
    $number_to_words_string = "";

    //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
    for($i=0,$j=1;$i<9;$i++,$j++){
        if($i==0 || $i==2 || $i==4 || $i==7){
            if($number_array[$i]=="1"){
                $number_array[$j] = 10+$number_array[$j];
                $number_array[$i] = 0;
            }
        }
    }

    $value = "";
    for($i=0; $i<9; $i++){
        if($i==0 || $i==2 || $i==4 || $i==7){ $value = $number_array[$i]*10; }
        else{ $value = $number_array[$i];    }
        if($value!=0){ $number_to_words_string.= $words["$value"]." "; }
        if($i==1 && $value!=0){ $number_to_words_string.= "Crores "; }
        if($i==3 && $value!=0){ $number_to_words_string.= "Lakhs ";    }
        if($i==5 && $value!=0){ $number_to_words_string.= "Thousand "; }
        if($i==6 && $value!=0){ $number_to_words_string.= "Hundred "; } //&amp;
    }
    if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
    //return "<strong>Taka in word: </strong> " . ucwords(strtolower($number_to_words_string)) . " Only.";
    return ucwords(strtolower($number_to_words_string)) . " Only.";
}
//echo taka_in_words("987654321");



function limit_words($string, $word_limit) {
    $string = strip_tags($string);
    $words = explode(' ', strip_tags($string));
    $return = trim(implode(' ', array_slice($words, 0, $word_limit)));

    if (strlen($return) < strlen($string)) {
        $return .= '...';
    }
    return $return;
}



function settings( $field_name ) {
    $settings = DB::table('settings')->first();
    return $settings->$field_name;
}


function count_another_table_data( $table_name, $where_id, $id ) {
    $count_data = DB::table($table_name)->where($where_id, $id)->count();
    return $count_data;
}
//echo count_another_table_data('terminals', 'program_id', $program->program_id);


function file_size($url){
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);

    $data = curl_exec($ch);
    $size = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

    curl_close($ch);
    return $size;
}
//echo file_size(get_headers("http://localhost/ledkioskbd/public/uploads/SuperAdmin/program_id_1/screenFullImage_fullscreen_chrysanthemum.jpg",1))['content-length'];


function human_file_size($url){
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, TRUE);

    $data = curl_exec($ch);
    $clen = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

    if($clen) {
        switch ($clen) {
            case $clen < 1024: $size = $clen . ' B'; break;
            case $clen < 1048576: $size = round($clen / 1024, 2) .' KB'; break;
            case $clen < 1073741824: $size = round($clen / 1048576, 2) .' MB'; break;
            case $clen < 1099511627776: $size = round($clen / 1073741824, 2) .' GB'; break;
        }
    }
    curl_close($ch);
    return $size;
}
//echo human_file_size(get_headers("http://localhost/ledkioskbd/public/uploads/SuperAdmin/program_id_1/screenFullImage_fullscreen_chrysanthemum.jpg",1))['content-length'];



function file_type($url){
    $file_type = image_type_to_mime_type(exif_imagetype($url));
    return $file_type;
}

function file_resolution($url){
    list($width, $height, $type, $attr) = getimagesize($url);
    return $width . "x" . $height;
}

function image_resize_to_thumbnail($files, $dest_path){

    $file_name_WithExt    = $files->getClientOriginalName();
    $file_name_WithoutExt = Str::slug(pathinfo($file_name_WithExt, PATHINFO_FILENAME)) ;
    $extension            = strtolower($files->getClientOriginalExtension());

    $file_name            = $file_name_WithoutExt .".". $extension;

    //$image_size           = $files->getSize(); /*must be before move()*/
    $image_properties       = getimagesize($files); /*get width x Height*/
    //$image_type           = $files->getClientMimeType();
    $image_type             = $image_properties[2]; /*get image type code*/

    //$temp_file = $_FILES['employee_photo']['tmp_name'];
    $temp_file = $files->getPathName();

    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image_resource_id = imagecreatefromjpeg($temp_file);
            $target_layer = fn_image_resize($image_resource_id,$image_properties[0],$image_properties[1]);
            imagejpeg($target_layer,$dest_path . $file_name_WithoutExt ."_thumb.". $extension);
            break;

        case IMAGETYPE_GIF:
            $image_resource_id = imagecreatefromgif($temp_file);
            $target_layer = fn_image_resize($image_resource_id,$image_properties[0],$image_properties[1]);
            imagegif($target_layer,$dest_path . $file_name_WithoutExt ."_thumb.". $extension);
            break;

        case IMAGETYPE_PNG:
            $image_resource_id = imagecreatefrompng($temp_file);
            $target_layer = fn_image_resize($image_resource_id,$image_properties[0],$image_properties[1]);
            imagepng($target_layer,$dest_path . $file_name_WithoutExt ."_thumb.". $extension);
            break;

        default: echo "Invalid Image type.";
    }
}

function fn_image_resize($image_resource_id,$width,$height) {
    $target_width =200;
    $target_height =200;
    $target_layer=imagecreatetruecolor($target_width,$target_height);
    imagecopyresampled($target_layer,$image_resource_id,0,0,0,0,$target_width,$target_height, $width,$height);
    return $target_layer;
}

function show_resized_picture_url($url, $file_name){
    $extension = ".". last(explode(".", $file_name));
    $file_name_without_extension = str_replace(($extension), "", $file_name);
    return $url ."/". $file_name_without_extension ."_thumb". $extension;
};

//function getDuration($file){
//    if (file_exists($file)){
//        ## open and read video file
//        $handle = fopen($file, "r");
//        ## read video file size
//        $contents = fread($handle, filesize($file));
//        fclose($handle);
//        $make_hexa = hexdec(bin2hex(substr($contents,strlen($contents)-3)));
//        $duration = '';
//        if (strlen($contents) > $make_hexa){
//            $pre_duration = hexdec(bin2hex(substr($contents,strlen($contents)-$make_hexa,3))) ;
//            $post_duration = $pre_duration/1000;
//            $timehours = $post_duration/3600;
//            $timeminutes =($post_duration % 3600)/60;
//            $timeseconds = ($post_duration % 3600) % 60;
//            $timehours = explode(".", $timehours);
//            $timeminutes = explode(".", $timeminutes);
//            $timeseconds = explode(".", $timeseconds);
//            $duration = $timehours[0]. ":" . $timeminutes[0]. ":" . $timeseconds[0];
//        }
//        return $duration;
//    }
//    else {
//        return false;
//    }
//}



function timezone_list() {
    $zones_array = array();
    $timestamp = time();
    foreach(timezone_identifiers_list() as $key => $zone) {
        date_default_timezone_set($zone);
        $zones_array[$key]['zone'] = $zone;
        $zones_array[$key]['diff_from_GMT'] = '(UTC/GMT' . date('P', $timestamp) . ")";
    }

    echo '<label for="timezone" class="control-label">Time Zone</label>';
    echo '<select name="timezone" id="timezone" class="custom-select">';
    echo '<option value="0">Time Zone</option>';
    foreach($zones_array as $t) {
         echo '<option value="' . $t['zone'] .'"' . $t['zone'] === settings( 'timezone' ) ? 'selected="selected"' : '' . $t['diff_from_GMT'] . ' - ' . $t['zone'] . '</option>';
    }
    echo '</select>';
}


function unique_serial_key(){
    $length = 20;
    $dash_length = 4;
    return implode( '-', str_split( substr( strtoupper( md5( time() . rand( 1000, 9999 ) ) ), 0, $length ), $dash_length ) );
}

function license_key($suffix = null) {
    if(isset($suffix)){
        $num_segments = 3;
        $segment_chars = 6;
    }else{
        $num_segments = 4;
        $segment_chars = 5;
    }

    $tokens = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
    $license_string = '';

    for ($i = 0; $i < $num_segments; $i++) {
        $segment = '';
        for ($j = 0; $j < $segment_chars; $j++) {
            $segment .= $tokens[rand(0, strlen($tokens)-1)];
        }
        $license_string .= $segment;
        if ($i < ($num_segments - 1)) {
            $license_string .= '-';
        }
    }

    if(isset($suffix)){
        if(is_numeric($suffix)) {   // Userid provided
            $license_string .= '-'.strtoupper(base_convert($suffix,10,36));
        }else{
            $long = sprintf("%u\n", ip2long($suffix),true);
            if($suffix === long2ip($long) ) {
                $license_string .= '-'.strtoupper(base_convert($long,10,36));
            }else{
                $license_string .= '-'.strtoupper(str_ireplace(' ','-',$suffix));
            }
        }
    }
    return $license_string;
}
//echo license_key();




function is_user_role($role_name){
    $role_id = DB::table('user_roles')->where('role_name', $role_name)->value('role_id');
    if( Auth::user()->role_id == $role_id ){
        return true;
    };
}





function shapeSpace_disk_usage() {
    $disktotal = disk_total_space ('/');
    $diskfree  = disk_free_space  ('/');
    $diskuse   = round (100 - (($diskfree / $disktotal) * 100)) .'%';

    return $diskuse;
}

//function memory_usage() {
//    $memory_usage = "Memory Usage: ". round(memory_get_peak_usage()/1048576, 2) ." MB";
//    return response()->json($memory_usage);
//}
//echo memory_usage();

//function app_used_disk_space($folder_name) {
//    $file_size = 0;
//    $folder_path = Storage::disk($folder_name);
//    foreach( $folder_path->allFiles('/') as $file){
//        $file_size += $folder_path->size($file);
//    }
//    $file_size = number_format($file_size / 1048576,2) . " MB";
//    dd($file_size);
//}
//echo app_used_disk_space('uploads');




function get_division_wise_vehicle_count($division_id, $vehicle_type = null) {
    if($vehicle_type == null){
        $vehicle_count = DB::table('vehicles')
            ->leftJoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
            ->leftJoin('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
            ->select('vehicle_types', 'division_id')
            ->where('division_id', $division_id)
            ->count();
    }
    else{
        $vehicle_count = DB::table('vehicles')
        ->leftJoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
        ->leftJoin('drivers', 'vehicles.driver_id', '=', 'drivers.driver_id')
        ->select('vehicle_types', 'division_id')
        ->where('vehicle_type', $vehicle_type)
        ->where('division_id', $division_id)
        ->count();
    }
    return $vehicle_count;
}

function get_vehicle_count($vehicle_type = null) {
        $vehicle_count = DB::table('vehicles')
        ->leftJoin('vehicle_types', 'vehicles.vehicle_type_id', '=', 'vehicle_types.vehicle_type_id')
        ->where('vehicle_type', $vehicle_type)
        ->select('vehicle_types')->count();
    return $vehicle_count;
}


function get_vehicle_wise_trip_count($vehicle_type = null) {
    $vehicle_type_id = DB::table('vehicle_types')->where('vehicle_type', strtolower($vehicle_type))->value('vehicle_type_id');
    $vehicle_count = DB::table('rider_trips')->where('vehicle_type_id', $vehicle_type_id)->where('trip_status', '!=', 'ride_request')->count();

//    if($vehicle_type == null){
//        $vehicle_count = DB::table('rider_trips')->count();
//    }
//    else {
//        $vehicle_count = DB::table('rider_trips')->where('vehicle_type_id', $vehicle_type_id)->count();
//    }
    return $vehicle_count;
}


function get_single_vehicle_trip_count($vehicle_id) {
    $vehicle_count = DB::table('rider_trips')->where('vehicle_id', $vehicle_id)->count();
    return $vehicle_count;
}
