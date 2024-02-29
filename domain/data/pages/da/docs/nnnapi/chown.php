<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
chown ændrer bruger og kan kun udføres af bruger www-data. Den er rekursiv når selected er et direrctory - stoppende hvis sub directories ikke er samme oprindelige ejer og heller ikke skiftende 'ejerskab' til filer som ikke har samme ejerskab som valgte directory.
EOMD,actors\srclf('progs/NNNAPI.php','    function chown','^$','function travChGrp','^$'),actors\tocNavigate($func)];