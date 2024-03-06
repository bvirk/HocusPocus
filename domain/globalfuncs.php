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

/**
 * Outputs list of values to apache error.log , where each argument is one its own line. A value that ends in '=' has the effect of next value being on same line, which can be used as a label for info about a variable name - eg. 'myVar=',$myVar,... Array values is colon space prefixed their keys
 
 * @param mixed $argArr is the list of values
 */
function errLog(... $argArr): void {
    error_log(varLnStr(... $argArr));
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
   
/**
 * excludes files starting with dot - which includes the Dir itself '.' and parent dir '..'
 *  @return array of files without path
 */
function nodotScandir($file):array {
    return  array_filter(scandir($file),function($i) {return substr($i,0,1) !== '.';});
}

/**
 * Outputs list of values, where each argument is terminated by "\n"
 * A value that ends in '=' has the effect of not being terminated - making it suitable to be a
 * label for info about a variable name - eg. 'myVar=',$myVar,... Array values is colon space prefixed their keys
 
 * @param mixed $argArr is the list of values
 */
function varLn(... $argArr):void {
    echo varLnstr(... $argArr);
}

/**
 * Returns list of values, where each argument is terminated by "\n"
 * A value that ends in '=' has the effect of not being terminated - making it suitable to be a
 * label for info about a variable name - eg. 'myVar=',$myVar,... Array values is colon space prefixed their keys
 
 * @param mixed $argArr is the list of values
 * @return string where items is terminated by "\n"
 */
function varLnStr(... $argArr):string {
    return varsStr("\n",...$argArr);
}

/**
 * Returns list of values, where each argument is terminated by '<br>'
 * A value that ends in '=' has the effect of not being terminated - making it suitable to be a
 * label for info about a variable name - eg. 'myVar=',$myVar,... Array values is colon space prefixed their keys
 
 * @param mixed $argArr is the list of values
 * @return string where items is terminated by '<br>'
 */
function varBrStr(... $argArr) {
    return varsStr("<br>",...$argArr);
}

/**
 * Returns list of values, where each argument is terminated with a string - often "\n" or '<br>'
 * A value that ends in '=' has the effect of not being terminated - making it suitable to be a
 * label for info about a variable name - eg. 'myVar=',$myVar,... Array values is colon space prefixed their keys
 
 * @param string $nl is in most cases one of "\n", '&lt;br&gt;' or ''
 * @param mixed $argArr is the list of values
 * @return string where items is terminated by $nl
 */
function varsStr(string $nl,... $argArr):string {
    $lines='';
    foreach ($argArr as $arg) {
        if (is_array($arg)) {
            if (count($arg)) {
                foreach ($arg as $i => $subarg)
                    $lines .= "$i: ".varsStr($nl,$subarg);
            } else 
                $lines .= 'array[]'.$nl;
        } else
            $lines .=
                gettype($arg) == 'string' && $arg != '' && substr($arg,strlen($arg)-1,1) == '=' 
                    ? "$arg "
                    : var_export($arg,true).$nl;
    }
    return $lines;
} 
