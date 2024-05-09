<?php
define("APACHE_USER",exec('whoami'));
define("AUTHFILE","config/encrypted.php");
define("CONFIRM_COMMAND",'errOrConf');
define("DEFCONTENT",'pages');
define("DEFDATADIR",'data');
define("DEFAULTEDITMODE","file");
define("DEFPAGESESVAR",'defaultpage');
define("FILETOEDIT",$_SERVER['DOCUMENT_ROOT'].'/config/filetoedit.txt');
define("IS_PHP_ERR",'errOrConf');
define("LANGUAGES", array('da' => 'Danish','en' => 'English'));
define("LOGGEDIN",'loggedin');
define("PHP_ERR",'phpError');
define("REDRAW_DIR",'redrawDir');
define("REDRAW_IMG_DIR",'redrawImgDir');
define("REDRAW_UPPERDIR",'redrawUpperDir');
function OSGroups() {
    $users=[];
    foreach (file('/etc/passwd') as $user)  {
        $uArr = explode(':',$user);
        if ( $uArr[2] >= 1000 && $uArr[0] !== 'nobody')
            $users[] = $uArr[0];
    }
    $groups=[APACHE_USER];
    foreach (file('/etc/group') as $group) {
        $gArr = explode(':',$group);
        if ( $gArr[2] >=1000 && !in_array($gArr[0],$users) && $gArr[0] !== 'nogroup')
            $groups[]=$gArr[0];
    }
    return $groups;
}
define("USERS",OSGroups());

