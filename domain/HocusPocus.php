<?php
use utilclasses\Parsedown;

/**
 * Write to last array element
 * @param value
 * @param array which last element gets value
 */
function wrtEnd($value,&$array) {
    $array[count($array)-1]=$value;
}

/**
 * Replaces pattern in last array element in $t with last element in $c
 */
function insList(&$t,&$c) {
    $i = count($t)-1;
    $t[$i] = preg_replace('/#html#/',end($c),$t[$i],1);
    if (count($c)>1) 
        if (preg_match('/#html#/',$t[$i]) == 0) {
            array_pop($c);
            wrtEnd(end($c).array_pop($t),$c);
        } else
            wrtEnd('',$c);
}



abstract class HocusPocus {
    use /* trait */ actors\Pagefuncs;
    
    protected $body='';
    protected $useMarkDown=false;

    function __construct() { 
        headerCTText();
    }
    
    function enheritPathElements() {
        $e_pe=[];
        $classHierArr= array_reverse(class_parents($this));
        if (is_array($classHierArr)) {
            foreach ($classHierArr as $cName) {
                $bSlPos=strrpos($cName, "\\");
                if ($bSlPos !== false) 
                    $e_pe [] = substr($cName, $bSlPos + 1);
            }
        }
        return $e_pe;
    }

    function defCall($func) {
        /** @var array $pe */ global $pe;
        $classPath = strtolower(str_replace('\\', '/', get_class($this)));
        $imgPath ='/img/'.implode('/',$pe);
        $incPath = "data/$classPath/$func";
         
        if (actors\datafileExists($incPath)) {
            $dataVarsFile='datavars/'.implode('/',$this->enheritPathElements()).'.php';
            if (file_exists($dataVarsFile))
                include($dataVarsFile);
            $content = include($incPath); // the datafile
            if (!is_array($content))
                $content = [$content];
            $tStack = [];
            $cStack[] = '';
            foreach($content as $elem) {
                if (/* template element */ substr($elem,0,3) == '<!<') {
                    $tStack[] = substr(preg_replace('/\s+#html#/','#html#',preg_replace('/\s+</','<',$elem)),2);
                    $cStack[] = '';
                    continue;
                }
                [$endsList,$elem] = str_ends_with($elem,'>!>') ? [true,substr($elem,0,-3)] : [false,$elem]; 
                if ($elem) {
                    $html = $this->useMarkDown ? (new Parsedown())->text($elem) : $elem;
                    wrtEnd(end($cStack).$html,$cStack);
                }
                if ($endsList)
                    insList($tStack,$cStack);
                
            }
            while( count($cStack) >1 ) 
                insList($tStack,$cStack);
            $this->body = $tStack[0] ?? $cStack[0];

            $this->stdContent();

        } else { // neither $incPath.'.md' nor $incPath.'.php' is the name of an existing file
            if ($pe[0] == DEFCONTENT ) {
                $this->noDataAvail( 
                    //"$classPath/$func.[php|md]"       // developer mode
                    ""                              // production mode
                );
            } else
                $this->noDataAvail("$classPath/$func");
        }

            
    }


    function noDataAvail($class) {
        if (strlen($class))
            throw new Exception("\nno file: /data/$class.[php|md]");
        else
            echo "<script>window.open('/".DEFCONTENT.'/'.array_key_first(LANGUAGES)."/index','_self');</script>";
    }

    abstract function stdContent();
    
}
