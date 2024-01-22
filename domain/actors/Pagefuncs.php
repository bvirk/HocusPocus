<?php
namespace actors;

function baseClass($classFile) {
    foreach (file($classFile) as $line)
        if (preg_match('/^class/',$line))
            return preg_replace('/^class\s+\w+\s+extends\s+([\w\\\\]+)\s*{\s*/','$1',$line);
    return false;
}
/**
 * Append the extension by which the file exists
 * @param string &$dataFile without extension
 * @return true if an existing match with some extension found
 */
function datafileExists(string &$dataFile, array $extensions = ['.md','.php']):bool {
    foreach ($extensions as $ext)
        if (file_exists("$dataFile$ext")) { 
            $dataFile .= $ext;
            return true;
        }
    return false;
}

/**
 * Echos javascript assignment list
 * @param array $assm is all the assignment
 * @param string $dclr is the declaration before each assignment 
 */
function echoAssignments(array $assm, string $dclr='const'):void {
    foreach ($assm as $asm)
        echo "   $dclr $asm;\n";
}

function enheritChain($phpClassFile,$isFirstCall=true) {
    $slash= $isFirstCall ? '' : "\\";
    
    $extendsParm=\actors\baseClass($phpClassFile);
    if (!$extendsParm) 
        return "fail";
    $nextPhpClassFile = str_starts_with($extendsParm,"\\") 
        ? $_SERVER['DOCUMENT_ROOT'].str_replace("\\",'/',$extendsParm).'.php'
        : dirname($phpClassFile)."/$extendsParm.php";
    $baseExtParmBase = basename(str_replace("\\",'/',$extendsParm)); 
    return (strpos($nextPhpClassFile,'PageAware') === false ? enheritChain($nextPhpClassFile,false) : '')
            ."$baseExtParmBase$slash";
}


function fileSpec($path) {

    $perms = fileperms($path);
    $info = '';
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
            (($perms & 0x0800) ? 's' : 'x' ) :
            (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
            (($perms & 0x0400) ? 's' : 'x' ) :
            (($perms & 0x0400) ? 'S' : '-'));

    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
            (($perms & 0x0200) ? 't' : 'x' ) :
            (($perms & 0x0200) ? 'T' : '-'));
    return gmdate("Y-m-d H:i:s",filemtime($path)).' '.posix_getpwuid(fileowner($path))['name']." $info ".formatBytes(filesize($path));
}


function formatBytes($size, $precision = 2) {
    if (!$size)
        return '0B';
    $base = log($size, 1024);
    $suffixes = array('B', 'K', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

function isLoggedIn() {
    return in_array($_SESSION['loggedin'],USERS);
}

function isAutorizeddDir($path) {
    //error_log('$path='.$path);
    return $path !== '/da/loggedin' || in_array($_SESSION['loggedin'],USERS);
}


function kvsepEncode($arr,$kv='=',$sep=';') {
    $itemSep='';
    $str='';
    foreach ($arr as $key => $value) {
        $str .= "$itemSep$key$kv$value";
        $itemSep=$sep;
    }
    return $str;
}

function queryString($exclude='path') {
    $ret='';
    foreach ($_GET as $k => $v)
        if ($k !== $exclude)
            $ret .= '&'.$k.($v !== '' ? '='.$v : '');
    return $ret;
} 

function lastmRef($url,$attName) {
	return "$attName='$url?lastm=".filemtime($_SERVER['DOCUMENT_ROOT'].$url)."'";
}

function mdLinkMatch($line,&$matchesRef) {
    return preg_match('/^-\s+\[([^\]]+)\]\(([\w\/]+)\)/',$line,$matchesRef);
}
/**
 * showFilenameHeadEnum:
 *  0: dont show
 *  1: basename
 *  2: full pathname
 */
function src($fileN,$linesArray,$useLines,$showFilenameHeadEnum) {
    $out ='';
    $showFileNamesEnum=$showFilenameHeadEnum;
    while (count($linesArray)) {
        $pairs = [array_shift($linesArray),array_shift($linesArray) ?? 999];
        if (gettype($pairs[0]) == 'string') 
            $pairs[0] = (array_key_first(preg_grep("/$pairs[0]/",file($_SERVER['DOCUMENT_ROOT']."/$fileN"))) ?? 0 )+1;
        if (gettype($pairs[1]) == 'string')
            $pairs[1]=$pairs[0]+intval($pairs[1]-1);
        $out .=  (new \utilclasses\SrcLister(
             $fileN
            ,$pairs[0]
            ,$pairs[1]
            ,$useLines
            ,$showFileNamesEnum))->lines();
        $showFileNamesEnum=0;
    }
    return $out;
}

/**
 * basename source
 */
function srcb($fileN,... $linesPatt) { // _S_ou_rc_e with _base filename heading
    return src($fileN,$linesPatt, false, 1);
}

/**
 * basename linenumbered source
 */
function srclb($fileN,... $linesPatt) { // _S_ou_rc_e with _lines and _base filename heading
    return src($fileN,$linesPatt, true, 1);
}

/**
 * pathname source
 */
function srcf($fileN,... $linesPatt) { // _S_ou_rc_e with _f_ilename heading
    return src($fileN,$linesPatt, false, 2);
}

/**
 * pathname linenumbered source
 */
function srclf($fileN,... $linesPatt) { // _S_ou_rc_e with _l_ines and _f_ilename heading
    return src($fileN,$linesPatt, true, 2);
}

/**
 * Extract <h2 >headline from '# toc' prelined markdown list in page index 
 * @param string $func is page name
 * @param int $prePathLevel prepends with path elents from url
 * @return string headline text
 */
function tocHeadline(string $func, int $prePathLevel=0) {
    global $pe;
    $headLine=false;
    foreach(tocOfIndex($func) as $line) {
        if (mdLinkMatch($line,$matches) == /* end of list (empty line) */ 0)
            break;
        if ($matches[2] == $func) {
            $hLines= $prePathLevel ? array_slice($pe,-1-$prePathLevel,$prePathLevel) : [];
            $hLines[]=$matches[1];
            $hx = '##';
            foreach ($hLines as $hLine) {
                $headLine .= "$hx $hLine\n";
                $hx .= '#';
            } 
            break;
        }
    }
    return $headLine ?: "## headline not found";
}

 /**
 * Makes navigation links from '# toc' prelined markdown list in page index 
 * @param string $func is page name
 * @return string 3 links in row, previous, toc and next. 
 */
function tocNavigate(string $func) {
    global $pe;
    [$prev,$next,$prevFound] = [[],[],false];
    $upperFunc = $func == 'index' ? array_slice($pe,-2,1)[0]."/$func" : $func;
    foreach(tocOfIndex($func) as $line) {
        if (mdLinkMatch($line,$matches) == /* end of list (empty line) */ 0) 
            break;
        if ($matches[2] !== $upperFunc && $matches[2]) // !== "$func/index" )
            if (!$prevFound) {
                $prev = $matches;
            } else {
                 $next = $matches;
                 break;
            }
        else
            $prevFound = true;
        
    }
    if ($func=='index') {
        //$prev[1] = "../".$prev[1];
        $prev[2] = "../".$prev[2];
        if (array_key_exists(1,$next)) {
            //$next[1] = "../".$next[1];
            $next[2] = "../".$next[2];
        }
    }
    $prevLinks = array_key_exists(1,$prev) ? "[←]($prev[2])<br>[$prev[1]]($prev[2])" : '&nbsp;';
    $nextLinks = array_key_exists(1,$next) ? "[→]($next[2])<br>[$next[1]]($next[2])" : '&nbsp;';
    $tocLink = $func=='index' ? '../index' : 'index';
    return "\n<div class='contentNav'>\n\n$prevLinks\n\n[↰<br>≡]($tocLink)\n\n$nextLinks\n</div>\n\n";
}


function tocOfIndex($func) {
    global $pe;
    $indexFile = 'data/'.implode('/',array_slice($pe,0,-1-($func == 'index'))).'/index';
    if (! datafileExists($indexFile))
        return false;
    $indexLines = file($indexFile);
    $tocLine = array_key_first(preg_grep('/^##*\s+TOC/i',$indexLines));
    return $tocLine === NULL ? false :  array_slice($indexLines,$tocLine+1);
}

trait PageFuncs {
}
