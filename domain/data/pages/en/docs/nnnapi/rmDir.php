<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Fjern directory. Applies to:
- all files in the directory
- the directory itself
- associated special css and js
- images
- img directory
- pages class to which the data directory was content

rmDir actual transfers to trash/, from where it can all be re-established with [undoTrash](undoTrash)
EOMD,actors\srclf('progs/NNNAPI.php','function rmDir',6,'function trashDir',25),<<<EOMD

EOMD,actors\tocNavigate($func)];