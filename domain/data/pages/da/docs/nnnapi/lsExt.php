<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
lsExt viser et virtuelt dir af en af grupperne: css filer, javascript file eller image filer, som tilhører en side.
EOMD,actors\srclf('progs/NNNAPI.php','    function lsExt','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageExternsOfType','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageImages','^$')
    ,actors\srclf('actors/Pagefuncs.php','function pageExterns','^$')
,actors\tocNavigate($func)];