<script>
    var allFuncs={};
    const defaultPage=<?="'".defaultPage()."';\n"?>
    const isLoggedin=<?=(in_array($_SESSION[LOGGEDIN],USERS)? 'true' : 'false').";\n"?>
    const isPHPErr=<?="'".IS_PHP_ERR."';\n"?>
    const loggedInIsApache=<?=($_SESSION[LOGGEDIN] == APACHE_USER ? 'true' : 'false').";\n"?>
    const redrawDir=<?="'".REDRAW_DIR."';\n"?>
    const redrawImgDir=<?="'".REDRAW_IMG_DIR."';\n"?>
    const redrawUpperDir=<?="'".REDRAW_UPPERDIR."';\n"?>
</script>
<script type='module' <?= actors\lastmRef('/jsmodules/StdMenu/main.js','src') ?>></script> 
