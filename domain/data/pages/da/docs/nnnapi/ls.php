<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Ls bruges til at lave dirlisten. Som tilbagemelding efter fil ændringer bruges ls også til at gentegne fillisten så det syner at der er blevet oprettet, ændret eller fjernet fra det directory der vises.
EOMD,actors\srclf('progs/NNNAPI.php','function ls','^$'),<<<EOMD
$srcExpl
Array af Arrays af filespec. - hvert indre array bestående af filnavn, hvorvidt det er et dir, specifikation af filen og dennes class hierarki.
</div>

EOMD,actors\tocNavigate($func)];