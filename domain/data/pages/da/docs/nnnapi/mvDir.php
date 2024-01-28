<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
mv og mvDir er det sammen i dialog menu, det er hvis målet for omdøbning er et directory mvDir kaldes. Der er altså tale om omdøbning indenfor samme directory.  
Omdøbning af et directory medfører
1. directory som 'datadir' omdøbes
2. tilsvarende class omdøbes.
3. hvis det directory class ligger i også har et directory med samme navn som class men lowercase som første tegn, så:
    1. omdøbes dette  directory til det nye navn
    2. namespaces delen i alle classes i det nye directory tree ændres til det nye navn.
4. img path omdøbes
5. css og js path elementer omdøbes.

EOMD,actors\srclf('progs/NNNAPI.php','function mvDir',18),<<<EOMD

EOMD,actors\tocNavigate($func)];