<?php
return ["<!<div class='auto80'>#html#</div>",<<<EOMD
chown changes user and can only be executed by user www-data. It is recursive when selected is a directory - stopping if sub directories do not have the same original owner and also not changing 'ownership' of files that do not have the same ownership as the selected directory
EOMD,actors\srclf('progs/NNNAPI.php','    function chown','^$','function travChGrp','^$'),actors\tocNavigate($func)];