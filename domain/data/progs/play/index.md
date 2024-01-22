<?php
$subp = substr($_SERVER['SERVER_ADDR'],0,7) == '192.168' ? 'homebuilder' : 'digital nomad';
return "## hello again $subp ". ($_GET['name'] ?? 'nobody')."\n";
