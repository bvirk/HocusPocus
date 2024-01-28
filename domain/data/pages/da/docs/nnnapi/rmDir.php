<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Fjerner directory. Vedrører
- alle filer i the directory
- directory selv
- relaterede special css and js
- images
- img directory
- pages class for hvilket directory var indhold.

Der er tale om overførsel til trash/ hvorfra det hele kan reetablers med [undoTrash](undoTrash)
EOMD,actors\srclf('progs/NNNAPI.php','function rmDir',6,'function trashDir',25),actors\tocNavigate($func)];