<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
lsExt shows a virtual dir of one of the groups: css files, javascript file or image files that belong to a page.
EOMD,actors\srclf('progs/NNNAPI.php','    function lsExt','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageExternsOfType','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageImages','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageExterns','^$')
,actors\tocNavigate($func)];