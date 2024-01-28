<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Method emptyTrash empties directory trash/ which are used wit erasurements.
EOMD,srclf('progs/NNNAPI.php','function emptyTrash',4),<<<EOMD
$srcExpl
IS_PHP_ERR is used to just show 'emptied trash' in the dialogue menu's status line
</div>

EOMD,srclf('progs/NNNAPI.php','function removeBesidesRoot',10),<<<EOMD
$srcExpl
Only the directory on the first call is not deleted, due to option \$removeThisDir's default value.
</div>

EOMD,actors\tocNavigate($func)];