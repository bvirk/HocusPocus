<?php
require "globalfuncs.php";

function exceptions_error_handler($severity, $message, $filename, $lineno) {
    //errLog("$filename:$lineno");
    throw new ErrorException($message, 0, $severity, $filename, $lineno);
}

set_error_handler('exceptions_error_handler');

spl_autoload_register(function($classPath) {
    require_once str_replace("\\","/",$classPath).'.php'; // THIS MUST BE AT LINE 12
});

$pe=[];
$usesJSON=false;

instantiatePath();

function instantiatePath() {
    global $pe;
    global $usesJSON;

    /* We dont allow url ending with slash, because it ruins relative links */
    if ( str_ends_with($_REQUEST['path'] ?? '','/')) 
        exit(header('Location: /'.rtrim($_REQUEST['path'],'/'),true,302));



    /**
     * $_REQUEST['path'] is exploded to array $pe
     * last item is method of a class or a file referense (.md or .php)
     * second to last is the class responsible for creating the html document
     * from first to second to last is path elements from Document_root
     * shortcut exist for 0,1 or 2 path element in url
     */ 
    if (!array_key_exists('path',$_REQUEST)) // domain only 
        exit(header('Location: /pages/'.array_key_first(LANGUAGES).'/index',true,302));
    $pe = explode('/',$_REQUEST['path']);
    if (count($pe) == 1) // url that for sure not exists
        exit(header('Location: /pages/'.array_key_first(LANGUAGES).'/index',true,302));
    if (count($pe) == 2) // used for 2 path element /progs
        $pe[] = 'index';


    // second to last element in $pe 
    $class = ucfirst(array_slice($pe,-2,1)[0]);

    // indexes from {0 ... count-2 } of \$pe 
    $namespace =  implode("\\",array_slice($pe,0,-2));

    //Uncomment for inspection
    //header("Content-type: text/plain;charset=UTF-8");varln('path=',$_REQUEST['path'],'$pe=',$pe,'$class=',"$namespace\\$class",'method=',$pe[count($pe)-1]); exit;

    try {
        [new ("$namespace\\$class")(),$pe[count($pe)-1]]();
    } catch (Exception $e) {
        if ($e->getFile() == __FILE__ && $e->getLine() == 12 && strpos($e->getMessage(),'No such file or directory') > 0) 
            header('Location: '
                .$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.defaultPage());
        else {
            if ($usesJSON) {
                errLog($e);
                [$file,$line]=[$e->getfile(),$e->getLine()];
                file_put_contents(FILETOEDIT,str_replace(' ','_',$e->getMessage())." $file:$line");
                echo json_encode([IS_PHP_ERR,"PHP ERROR in .../".substr($e->getfile(),DOCROOTSTRLEN+1).":$line"]);
            } else {
                headerCTText();    
                echo "$e\n";
            }
        }
    }
}