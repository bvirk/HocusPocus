<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Skabelsen af et nyt data directory indebærer
1. nyt directory skabes
2. filen index.md deri skabes
3. class som kan instantieres med den kontekst som url til nye dir er, skabes

EOMD,actors\srclf('progs/NNNAPI.php','function mkDir','^$'),actors\tocNavigate($func)];