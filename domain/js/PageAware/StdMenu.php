<?php
global $pe;
echo "  <!-- Nasty globals -->\n  <script>\n   var allFuncs={};\n";

actors\echoAssignments([
    "defaultPage='".defaultPage()."'"        // used for navigation to home
    ,"isLoggedin=".(in_array($_SESSION[LOGGEDIN],USERS)? 'true' : 'false')// State of loggedin for the request
    ,"isPHPErr='".IS_PHP_ERR."'"                                            // identifier for signaling thown exception 
    ,"redrawDir='".REDRAW_DIR."'"
    ,"redrawUpperDir='".REDRAW_UPPERDIR."'"
]);

if (implode('/',$pe) != 'progs/edit/content'): ?>
$(  function() {
        let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
        if ( dialogState == 'on')
            allFuncs.hamDrawMenu();
    }
);
<?php endif; ?>
</script>
<script type='module' <?= actors\lastmRef('/jsmodules/StdMenu/main.js','src') ?>></script> 
