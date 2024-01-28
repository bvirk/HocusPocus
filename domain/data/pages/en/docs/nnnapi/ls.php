<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Ls is used to create the dir list. As feedback after file changes, ls is also used to redraw the file list so that it appears that something has been created, changed or removed from the directory that is displayed.
EOMD,actors\srclf('progs/NNNAPI.php','function ls',16),<<<EOMD
$srcExpl
Array of Arrays of filespecs - each inner array consisting of filename, whether it is a dir, specification of the file and its class hierarchy.
</div>

EOMD,actors\tocNavigate($func)];