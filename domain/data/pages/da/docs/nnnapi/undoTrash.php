<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Reetabler fra trash. Reetablering fra flere trashninger konflikter ikke da de er distinkte. Link renames. Flere undoTrash efter hinanden er uden effekt da copy bare overskriver og links ikke længere er i trash.
EOMD,srclf('progs/NNNAPI.php','function undoTrash','^$'),<<<EOMD
$srcExpl
IS_PHP_ERR bruges til at vise statuslinie i dialog menuen.
</div>

Strategien for trashning er at flytte, foranstillende enhver fil realtive pathname fra document root, med trash/. Dermed er  alt trashed med deres oprindelige path - og kan reetablers ved kopiering til destination uden foranstilte trash.

EOMD,srclf('progs/NNNAPI.php','function copySubDirsOf','^$'),<<<EOMD
$srcExpl
\$rootLen peger så langt ind i \$file at forreste trash ikke kommer med i destination for copy af fil eller rename af links.
</div>

EOMD,actors\tocNavigate($func)];