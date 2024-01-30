<?php
$dir = 'data/snut/demo';

//$b = chmod("config/filetoedit.txt",0111);
$stat = mkdir($dir);
/* copy ErrorException
access to dest
missing source
mising dir
OK - der kastes
*/
/* chmod ErrorException
no such file
permission
*/
/* mkdir exception
no path
permission
*/

return "stat=".($stat ? "true" : "false");