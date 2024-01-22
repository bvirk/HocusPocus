<?php
$num=0;
$exp=0;
$queryParm = ['General' => 'g','Xdebug' => 'x','Configuration' => 'c','Modules' => 'm','Environment' => 'e','Variables' => 'v','Help' => 'h'];
foreach ( $queryParm as $t => $q) {
    $num |= array_key_exists($q,$_GET) ? pow(2,$exp) : 0;
    $exp++;
}
if ($num==2)
    xdebug_info();
else
    if ($num != 64) {
        phpinfo($num ? $num : -1);
    } else {
        header('Content-type: text/plain;charset=UTF-8');
        foreach ($queryParm as $meaning => $parm)
            echo "$parm: $meaning\n";
    }
