<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Remove file. If it is index all this is 'removed'
- all files in the directory
- the directory itself
- associated special css and js
- images
- img directory
- pages class to which the data directory was content

rm actual transfers to trash/, from where it can all be re-established with [undoTrash](undoTrash)
EOMD,actors\srclf('progs/NNNAPI.php'
        ,'function rm\(','^$'
        ,'Removes a single datafile and what belongs','^$'
        ,'function trashDir','^$'),<<<EOMD

EOMD,actors\tocNavigate($func)];