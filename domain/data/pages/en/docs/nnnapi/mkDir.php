<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
The creation of a new data directory involves

1. new directory is created
2. the index.md file therein is created
3. class which can be instantiated with the context that the url to new dir is, is created

EOMD,actors\srclf('progs/NNNAPI.php','function mkDir','^$'),actors\tocNavigate($func)];