<?php
namespace utilclasses;

class SrcLister
{
    private $srcFile,$begLine,$lineCnt,$useLineNumbers,$showFileNameEnum;

    function __construct($srcFile,$begLine,$EndLine,$useLineNumbers,$showFileNameEnum) {
         $this->srcFile=$srcFile
        ;$this->begLine=$begLine
        ;$this->lineCnt=$EndLine-$begLine+1
        ;$this->useLineNumbers=$useLineNumbers
        ;$this->showFileNameEnum=$showFileNameEnum // 0:dont, 1:basename, 2 full pathname
        ;
        
    }

    function numbef($item) {
        return ($this->useLineNumbers ? (str_repeat(' ',$this->begLine<100?1+($this->begLine<10?1:0):0).$this->begLine++).' ': '' ).$item;
    }
    

    function lines() {
        $url = '/progs/html/source/file='.str_replace('.','|',$this->srcFile);
        $url = '/?path=progs/html/source&file='.$this->srcFile;
        $linktext = $this->showFileNameEnum == 
            2 ?  $this->srcFile : ($this->showFileNameEnum == 
            1 ? basename($this->srcFile) 
            : '');
        return 
           ($this->showFileNameEnum ? "##### [_$linktext".'_'."]($url)"."\n" : "").
           "```\n".implode(array_map([$this,'numbef'],array_slice(file($_SERVER['DOCUMENT_ROOT']."/$this->srcFile"),$this->begLine-1,$this->lineCnt)))."\n```\n";
    }

}
