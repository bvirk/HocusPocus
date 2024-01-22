<?php
if (!array_key_exists('refer',$_GET))
    return "#### no refer path given";
function docfile_exists($fileName) {
    return file_exists(DOC_ROOT."/$fileName");
}
function refs($wayPath) {
    $wayRefs = '';
    foreach (['css' => ['css'],'js' => ['js','php']] as $droot => $extArr)
        foreach($extArr as $ext) {
            $drootFilename = "$droot/$wayPath.$ext";
            $link = $ext == 'php' ? "/progs/html/source/file=$droot/$wayPath|$ext" : "/$droot/$wayPath.$ext";
            $wayRefs .= file_exists($drootFilename) 
                    ? "[$droot/$wayPath.$ext]($link)  \n" 
                    : "$droot/$wayPath.$ext  \n";
        }
    return $wayRefs;
}

$path = $_GET['refer'];
$ppe = explode('/',$path);
$pfunc = array_slice($ppe,-1,1)[0];
$pUrlDir=implode('/',array_slice($ppe,1,-1));
$pclassPath = implode('/',array_slice($ppe,0,-2)).'/'.ucfirst(array_slice($ppe,-2,1)[0]).'.php';
if (!docfile_exists($pclassPath))
    return "#### Url $path dont address a page";

$externsStr='';
foreach ([
     '#### page specials' => ["$pUrlDir/$pfunc"]
    ,'#### url hierarchy' => array_slice($ppe,1,-1)
    ,'#### class hierarchy' => explode("\\",\actors\enheritChain($pclassPath))] as $eType => $eTypeArr) {
    [$urltype,$acum,$slash]=[[],'',''];        
    foreach ($eTypeArr as $cpe) {
        $acum .= "$slash$cpe";
        $urltype[] = refs($acum);
        $slash='/';
    }
    $externsStr .= "$eType\n".implode("\n",$urltype)."\n";

}
return [<<< EOMD
## Extern references of $path
$externsStr
#### Image path  
img/$path
EOMD];