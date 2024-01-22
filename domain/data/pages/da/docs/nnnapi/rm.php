<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Fjern fil. Hvis det er index fjernes alle filer, det directory de lå i og den pages class hvortil data directoriet var indhold.  
Tilhørende speciel css og js, images og img directory 'slettes' også.  
Der er tale om overførsel til trash/ hvorfra det hele kan reetablers med [undoTrash](undoTrash)
EOMD,actors\srclf('progs/NNNAPI.php'
        ,'function rm\(','9'
        ,'Removes a single datafile and what belongs','18'
        ,'function trashDir','25'),<<<EOMD

EOMD,actors\tocNavigate($func)];