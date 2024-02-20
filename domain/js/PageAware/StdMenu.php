<?php

echo "  <!-- Nasty globals -->\n  <script>\n   var allFuncs={};\n";

actors\echoAssignments([
    "defaultPage='".defaultPage()."'"        // used for navigation to home
    ,"isLoggedin=".(in_array($_SESSION[LOGGEDIN],USERS)? 'true' : 'false')// State of loggedin for the request
    ,"isPHPErr='".IS_PHP_ERR."'"                                            // identifier for signaling thown exception 
    ,"redrawDir='".REDRAW_DIR."'"
    ,"redrawUpperDir='".REDRAW_UPPERDIR."'"
]);

actors\echoAssignments([
         "cid"          // index of current selected node that displays a files
        ,"curDirStr"    // current directory as it apears in url after https://domain.tld/ 
        ,"lid"          // DOM array of nodes that displays files
        ,"selDataPath"
        ,"loggedInOwnsSel" 
        ,"refType"
    ],"let"); ?>

$(  function() {
        let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
        if ( dialogState == 'on')
            allFuncs.hamDrawMenu();
    }
);
</script>
<script type='module' <?= actors\lastmRef('/jsmodules/StdMenu/main.js','src') ?>></script>