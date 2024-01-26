<?php
define("AUTHFILE","config/encrypted.php");
define("CSS_ROOT",$_SERVER['DOCUMENT_ROOT'].'/css');
define("DATA_ROOT",$_SERVER['DOCUMENT_ROOT'].'/data');
define("DOC_ROOT",$_SERVER['DOCUMENT_ROOT']);
define("DEFCONTENT",'pages');
define("DEFDATADIR",'data');
define("DEFAULTEDITMODE","file");
define("DEFPAGESESVAR",'defaultpage');
define("DOCROOTSTRLEN", strlen($_SERVER['DOCUMENT_ROOT']));
define("FILETOEDIT",$_SERVER['DOCUMENT_ROOT'].'/config/filetoedit.txt');
define("JS_ROOT",$_SERVER['DOCUMENT_ROOT'].'/js');
define("IMG_ROOT",$_SERVER['DOCUMENT_ROOT'].'/img');
define("IS_PHP_ERR",'<isPHPErr>');
define("LANGUAGES", array('da' => 'Danish','en' => 'English'));
define("PAGES_ROOT",$_SERVER['DOCUMENT_ROOT'].'/pages');
function OSUsers() {
    $all=[];
    foreach (file('/etc/passwd') as $user)  {
        $uArr = explode(':',$user);
        if ( $uArr[2] >= 1000 && $uArr[0] !== 'nobody')
            $all[] = $uArr[0];
    }
    return $all;
}
define("USERS",OSUsers());
define("APACHE_USER",exec('whoami'));

