<?php

// Sec Globals
$sec_key = "gg65RxmMmJjk9Io0OhR4eDtY"; // 24 bit Key
$sec_iv = "fYfhHeDm"; // 8 bit IV
$sec_bit_check = 8;
// bit amount for diff algor.
function pass($sid, $usr, $pw, $kind = 'staff') {
	global $dbsys;
	global $dbsite;

    # print "$sid $usr"; exit();

    $dbsite = new DB($sid);
    $field = $kind . 'id';
    $pwdObj = new Pwd();
    $pwdObj->setUsr($usr);
    $pwdObj->loadPwd();

    if (! $pwdObj->getPw()) {
        print "Failed to Load Pwd";
    }
    #print "$sid $usr $pw " . $pwdObj->getPw();exit;
    if (crypt($pw, $pwdObj->getPw()) == $pwdObj->getPw()) {
        if ($kind == 'staff') {
            // print "pass passed";exit;
            return $pwdObj->getStaffid();
        } if ($kind == 'contacts') {
            // print "pass passed";exit;
            return $pwdObj->getContactsid();
        }
        return false;
    } else {
        failOut('failed_passp',$sid);
    }
}

function dropCookie($sid, $usrid, $usr) {
    //
    // Cookie Format
    // $sitesid ,$usrid , $user , $pw, time()
    // where $usrid is either a staffid or a contactsid
    //
    $now = time();
    $line = $sid . '.' . $usrid . '.' . $usr . '.' .  $now;
    $value = encrypt($line);
    // print $line;exit;
    // $value = $line;
    setcookie("ATHENA", $value, time() + 7200, '/'); /* expire in 2 hour */
}

function chkCookie($kind = 'staff') {
    //
    // Cookie Format
    // $sitesid ,$usrid , $user , time()
    // where $usrid is either a staffid or a contactsid
    //
    global $dbsys;
    if (! isset($_COOKIE["ATHENA"])) {
        failOut('cookie_not_set');
    }
    $cke = decrypt($_COOKIE["ATHENA"]);
    // $cke = $_COOKIE["ATHENA"];

    $keywords = preg_split("/\./", $cke);

    $sid = $keywords[0];
    $usrid = $keywords[1];
    $usr = $keywords[2];
    $ts = $keywords[3];

//     if (! pass($sid, $usr, $pw, $kind)) {
//         failOut('cookie_pass_failed');
//     } else {
        dropCookie($sid, $usrid, $usr);
        $retID = $kind . 'id';
        $r[$retID] = $usrid;
        $r['sitesid'] = $sid;
        $r['usr'] = $usr;
        return $r;
//     }
    return 0;
}

function killCookie() {
    setcookie("ATHENA", '', time() - 3600); /* expire 1 hour ago */
}

function encrypt($text) {
    global $sec_key;
    global $sec_iv;
    global $sec_bit_check;

    $text_num = str_split($text, $sec_bit_check);
    $text_num = $sec_bit_check - strlen($text_num[count($text_num) - 1]);
    for ($i = 0; $i < $text_num; $i ++) {
        $text = $text . chr($text_num);
    }
    $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
    mcrypt_generic_init($cipher, $sec_key, $sec_iv);
    $decrypted = mcrypt_generic($cipher, $text);
    mcrypt_generic_deinit($cipher);
    return base64_encode($decrypted);
}

function decrypt($encrypted_text) {
    global $sec_key;
    global $sec_iv;
    global $sec_bit_check;

    $cipher = mcrypt_module_open(MCRYPT_TRIPLEDES, '', 'cbc', '');
    mcrypt_generic_init($cipher, $sec_key, $sec_iv);
    $decrypted = mdecrypt_generic($cipher, base64_decode($encrypted_text));
    mcrypt_generic_deinit($cipher);
    $last_char = substr($decrypted, - 1);
    for ($i = 0; $i < $sec_bit_check - 1; $i ++) {
        if (chr($i) == $last_char) {
            $decrypted = substr($decrypted, 0, strlen($decrypted) - $i);
            break;
        }
    }
    return $decrypted;
}

function failOut($why,$sid=0) {
    global $domain;
    killCookie();
    // TODO Log this
    if((isset($sid))&&($sid>99)){
    	header("Location: https://$sid.$domain/login?pf=y&w=$why");
    }else{
    	header("Location: https://www.$domain/?pf=y&w=$why");
    }




    exit();
}
