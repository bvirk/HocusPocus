<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Ny fil skabt ved kopiering fra config/datafile. Hvis mange filer skal oprettes med identiske mønste kan det svare sig at redigere config/datafile først.
EOMD,actors\srclf('progs/NNNAPI.php','function newFile','^$','function newDFile','^$'),<<<EOMD
$srcExpl

Filen skal residere længere nede i directory end i sprogvalgene i da/pages og have en af extension .md eller .php  
Return værdi har kun oplysende værdi ved fejl, ved succes gentegnes dirlisten.
</div>

EOMD,actors\tocNavigate($func)];