<?php
global $pe;
$thisUrl='url=/'.implode('/',$pe);
[$ahref,$atxt] = actors\isLoggedIn() 
    ? ["/?path=progs/loginRecieve/logout&amp;$thisUrl",$_SESSION[LOGGEDIN]] 
    : ["/?path=progs/html/login&amp;$thisUrl",'login'];
// IKON SHOWS WHAT CAN Be CHANGED TO - default is file -> cloud
[$editIkon,$editTip,$onclick ] = $_SESSION['editmode'] == DEFAULTEDITMODE 
? ['🌥 ☐','click to edit in browser','toEditMode("http");']
: ['🌥 ☑','click to edit locally only','toEditMode("file");'];

?>
<script>
    var allFuncs={};
    const defaultPage=<?="'".defaultPage()."';\n"?>
    const isLoggedin=<?=(in_array($_SESSION[LOGGEDIN],USERS)? 'true' : 'false').";\n"?>
    const isPHPErr=<?="'".IS_PHP_ERR."';\n"?>
    const loggedInIsApache=<?=($_SESSION[LOGGEDIN] == APACHE_USER ? 'true' : 'false').";\n"?>
    const redrawDir=<?="'".REDRAW_DIR."';\n"?>
    const redrawImgDir=<?="'".REDRAW_IMG_DIR."';\n"?>
    const redrawUpperDir=<?="'".REDRAW_UPPERDIR."';\n"?>
    let [ahref,atxt] = [<?="'$ahref','$atxt'" ?>];
    let [editIkon,editTip,onclick] = [<?="'$editIkon','$editTip','$onclick'"?>];
</script>
<script type='module' <?= actors\lastmRef('/jsmodules/StdMenu/main.js','src') ?>></script> 
