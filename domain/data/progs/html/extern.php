<?php
if (!array_key_exists('refer',$_GET))
    return "#### no refer path given";

$externsStr='';
$path = $_GET['refer'];
foreach(['css','js'] as $ext) {
    $externsStr .= "#### $ext hierarchy\n|filename|file info|type|\n|:--|:--|:--|\n";
    foreach (actors\pageExternsOfType($ext,$_GET['refer']) as $line ) {
        $externsStr .= $line[1] == 'e'
            ? "|[$line[0]](/?path=progs/html/source&file=$line[0])|$line[2]|"
            : "|$line[0]| $line[2]|"; 
        $externsStr .= "$line[3]|\n";
    }
}

return [<<< EOMD
## Extern references of $path
$externsStr
#### Image path  
img/$path

EOMD];