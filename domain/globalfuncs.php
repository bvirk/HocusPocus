<?php
require "defines.php";
session_start();
if (!array_key_exists(DEFPAGESESVAR,$_SESSION))
    $_SESSION[DEFPAGESESVAR] = array_key_first(LANGUAGES);
// USERS[0] automatically logged in if on LAN and no other user logged in. 
if (!array_key_exists('loggedin',$_SESSION) && substr($_SERVER['SERVER_ADDR'],0,7) == '192.168')
    $_SESSION['loggedin']=USERS[0];
if (!array_key_exists('editmode',$_SESSION))
    $_SESSION['editmode']=DEFAULTEDITMODE;

function defaultPage() {
    return DEFCONTENT.'/'.array_key_first(LANGUAGES).'/index';
}

function errLog(... $argArr) {
    error_log(varlnstr(... $argArr));
}

function headerCTText($usesJSONParm=false) {
    global $usesJSON;
    $usesJSON = $usesJSONParm;
    static $isSet=false;
    if (!$isSet) {
        header("Content-type: text/plain;charset=UTF-8");
        $isSet = true;
    }
}
   
function nodotScandir($file) {
    return  array_filter(scandir($file),function($i) {return substr($i,0,1) !== '.';});
}

function varln(... $argArr) {
    echo varlnstr(... $argArr);
}

function varlnstr(... $argArr) {
    $lines='';
    foreach ($argArr as $arg) {
        if (is_array($arg))
            foreach ($arg as $i => $subarg)
                $lines .= "$i: ".varlnstr($subarg);
        else
            $lines .=
                gettype($arg) == 'string' && substr($arg,strlen($arg)-1,1) == '=' 
                    ? "$arg "
                    : var_export($arg,true)."\n";
    }
    return $lines;
} 
