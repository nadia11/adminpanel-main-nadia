 <?php
//  function generate_password( $length = 8 ) {
//    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|";
//    $password = substr( str_shuffle( $chars ), 0, $length );
//    return $password;
//  }


//function generate_password( $length = 8 )  {
//
//    $password = "";
//    $possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";
//    $maxlength = strlen($possible);
//
//    if ($length > $maxlength) {
//      $length = $maxlength;
//    }
//
//    $i = 0;
//
//    while ($i < $length) {
//      $char = substr($possible, mt_rand(0, $maxlength-1), 1);
//
//      if (!strstr($password, $char)) {
//        $password .= $char;
//        $i++;
//      }
//    }
//    return $password;
//  }



//foreach( range('a', 'z') as $b){ echo $b; }
//foreach( range(0, 100) as $b){ echo $b; }


function generate_password( $length = 8 ) {
    $alpha = "abcdefghijklmnopqrstuvwxyz";
    $alpha_upper = strtoupper($alpha);
    //$alpha_upper = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $numeric = "0123456789";
    $special = ".-+=_,!@$#*%<>[]{}";
    $chars = "";

    if (isset($_POST['pwd_length'])) {
        if (isset($_POST['alpha']) && $_POST['alpha'] == 'on'){ $chars .= $alpha; }
        if (isset($_POST['alpha_upper']) && $_POST['alpha_upper'] == 'on'){ $chars .= $alpha_upper; }
        if (isset($_POST['numeric']) && $_POST['numeric'] == 'on'){ $chars .= $numeric; }
        if (isset($_POST['special']) && $_POST['special'] == 'on'){ $chars .= $special; }

        $length = $_POST['pwd_length'];
    }else {
        // default [a-zA-Z0-9]{9}
        $chars = $alpha . $alpha_upper . $numeric;
        //Select password length
        $length = isset($_POST['pwd_length']) ? $_POST['pwd_length'] : 18;
    }

    $len = strlen($chars);
    $pw = '';

    for ($i = 0; $i < $length; $i++) {
        $pw .= substr($chars, rand(0, $len - 1), 1);
    }
    //the finished password
    $pw = str_shuffle($pw);

    return $pw;
}
