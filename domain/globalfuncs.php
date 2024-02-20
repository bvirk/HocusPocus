<?php
require "defines.php";
session_start();
if (!array_key_exists(DEFPAGESESVAR,$_SESSION))
    $_SESSION[DEFPAGESESVAR] = array_key_first(LANGUAGES);
if (!array_key_exists(LOGGEDIN,$_SESSION)) {
//  remove outcommenting of following 3 lines for automatically login as USERS[0] when on LAN.  
//  if (substr($_SERVER['SERVER_ADDR'],0,7) == '192.168')
//      $_SESSION[LOGGEDIN]=USERS[0];
//  else
        $_SESSION[LOGGEDIN]='';
}
//setcookie('user',$_SESSION[LOGGEDIN],0,'/','',true,false);

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
                gettype($arg) == 'string' && $arg != '' && substr($arg,strlen($arg)-1,1) == '=' 
                    ? "$arg "
                    : var_export($arg,true)."\n";
    }
    return $lines;
} 
