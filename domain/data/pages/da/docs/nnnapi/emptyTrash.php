<?php

use function actors\tocHeadline;
use function actors\tocNavigate;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>"
,tocHeadline($func,1),
    <<<EOMD

Method emptyTrash tømmer directory trash/ som bruges ved sletninger.
EOMD,srclf('progs/NNNAPI.php','function emptyTrash','4'),<<<EOMD
$srcExpl
IS_PHP_ERR bruges til bare at vise 'emtied trash' i dialog menuens statuslinie
</div>

EOMD,srclf('progs/NNNAPI.php','function removeBesidesRoot','10'),<<<EOMD
$srcExpl
Alene directory ved første kald slettes ikke pga. option \$removeThisDir default value.
</div>
   
    
EOMD,tocNavigate($func)];