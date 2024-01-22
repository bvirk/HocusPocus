<?php

namespace actors;

abstract class PageAware extends \HocusPocus {
    protected $jsFiles = [];
    protected $cssFiles = [];
    protected $title = null;
    protected $useMarkDown=true;
    
    function __construct() {
        global $pe;
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php $this->getExterns(); ?>  
  <title><?= $this->title ?: implode('/',array_slice($pe,-2)) ?></title>
</head>
<body>
<?php }

    function __destruct() { 
?></body></html>
<?php }

    function extRef($tagAndOtherAttributes,$refAtt,$endTag,$base,$ext) {
        if (file_exists($_SERVER['DOCUMENT_ROOT']."$base.$ext")) 
            echo "  $tagAndOtherAttributes ".lastmRef("$base.$ext",$refAtt).">$endTag\n";
        else
            if ($ext=='js' && file_exists($_SERVER['DOCUMENT_ROOT']."$base.php"))
                include(__DIR__."/..$base.php");
    } 

    function getExterns() {
         /** @var array $pe */ global $pe;
        $bothPathElementsArray = ['url' => array_slice($pe,1,-1),'class' => $this->enheritPathElements()];
        
        $this->incFiles("<link rel='stylesheet' type='text/css'",'href','css','',$bothPathElementsArray);
        foreach($this->cssFiles as $cssFile)  
            echo "  <link rel='stylesheet' type='text/css' href='$cssFile'>\n";
        foreach($this->jsFiles as $jsFile)
            echo "  <script src='$jsFile'></script>\n";
        $this->incFiles("<script",'src','js','</script>',$bothPathElementsArray);
    }

    function incFiles($tagAndOtherAttributes,$refAtt,$ext,$endTag,$pathElementsArr) { 
        /** @var array $pe */ global $pe;
        foreach ($pathElementsArr as $pType => $pathElements) {
            $suffixPath = "/$ext";
            foreach ($pathElements as $runningPathElement) {
                $suffixPath .= '/'.$runningPathElement;
                $this->extRef($tagAndOtherAttributes,$refAtt,$endTag,$suffixPath,$ext);
            }
            if ($pType == 'url')
                $this->extRef($tagAndOtherAttributes,$refAtt,$endTag,"$suffixPath/".$pe[count($pe)-1],$ext);
    
        }
    }
}