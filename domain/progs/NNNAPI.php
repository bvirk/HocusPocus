<?php

namespace progs;

use function actors\datafileExists;

function catcher($f) {
    try {
        $fn = __NAMESPACE__."\\".$f;
        return $fn();
    } catch (\Exception $e) {
        return [IS_PHP_ERR,$e->getMessage().':'.$e->getLine().' failed'];
    }
}

function changeNameSpace($oldBasename,$newBasename,$path) {
    $all='';
    foreach (file($path) as $line)
        $all .= preg_match('/^namespace /',$line)
            ? preg_replace("/(?<=\\\\)$oldBasename/",$newBasename,$line)
            : $line;
    $numSaved = file_put_contents($path,$all);
    return $numSaved;

}

function changeNamespaceInDirs(string $old,string $new,string $path,$relPos=0) { 
    if (!$relPos)
        $relPos = strlen(PAGES_ROOT)+1;
    foreach (glob("$path/*") as $file)
        if (is_dir($file)) {
            changeNamespaceInDirs($old,$new,$file,$relPos);
        } else 
            changeNameSpace($old,$new,$file);
}

function copySubDirsOf($file,$rootLen=0) {
    if (!$rootLen)
        $rootLen=strlen($file)+1;
    if (!is_dir($file)) {
        $dest = substr($file,$rootLen);
        $destDir = dirname($dest); 
        if (!file_exists($destDir)) {
            lgdIn_mkdir($destDir);
        }
        if (is_link($file))
            lgdIn_rename($file,$dest);
        else
            lgdIn_copy($file,$dest);
    } else
        foreach (nodotScandir($file) as $fileInDir) 
            copySubDirsOf("$file/$fileInDir",$rootLen);
}

function hasSubDir($dir) {
    $globPatt=rtrim($dir,'/').'/*';
    $filesArr = glob($globPatt,GLOB_ONLYDIR);
    return count($filesArr) > 0; 
}

function indexIsLinkOf($file) {
    $index = dirname($file).'/index';
    datafileExists($index);
    if (!is_link($index))
        return false;
    return readlink($index) == basename($file);
}

function lgdIn_copy($from,$dest) {
    copy($from,$dest);
    chgrp($dest,$_SESSION[LOGGEDIN]);
}

function lgdIn_mkdir($dir) {
    $slash='';
    $acDir='';
    $oldMask=umask(0);
    foreach (explode('/',$dir) as $p) {
        $acDir .= "$slash$p";
        $slash='/';
        if (!file_exists($acDir)) {
            mkdir($acDir,0777);
            chgrp($acDir,$_SESSION[LOGGEDIN]);
        }
    }
    umask($oldMask);
}

function lgdIn_rename($from,$dest) {
    rename($from,$dest);
    chgrp($dest,$_SESSION[LOGGEDIN]);
}

/**
 * Make datadir
 * @return array [0,'ok']
 */
function mkDDir():array {
    $file = $_GET['curdir'].'/'.$_GET['txtinput'];
 
    if (array_key_exists('extension',pathinfo($file)) )
        return [CONFIRM_COMMAND,'extension not allowed'];
    if ($_GET['curdir'] === 'pages' )
        return [CONFIRM_COMMAND,'dir must be below pages'];
    mkdir("data/$file");
    copy('config/datafile',"data/$file/index.md");
    chmod("data/$file/index.md",0666);
    newClass($file);
    return [REDRAW_DIR,''];
}

function newDFile() {
    $file = $_GET['curdir'].'/'.$_GET['txtinput'];
    $ext = pathinfo($file)['extension'] ?? '';
    if ($_GET['curdir'] === 'pages')
        return [CONFIRM_COMMAND,'file must reside below pages'];
    if ( $ext !=='md' && $ext !== 'php')
        return [CONFIRM_COMMAND,"file must have extension 'md' or 'php'"];
    copy('config/datafile',"data/$file");
    chmod("data/$file",0606);
    chgrp("data/$file",$_SESSION[LOGGEDIN]);
    return [REDRAW_DIR,''];
}

function newClass($file) {
    $dirName = dirname($file);
    $baseName= basename($file);
    $classPath = "$dirName/".ucfirst($baseName).'.php';
    $retval=true;
    if (!file_exists($dirName)) {
        $retval = mkdir($dirName,0777);
    }
    return $retval &&
        file_put_contents($classPath,
        "<?php\nnamespace ".str_replace('/','\\',$dirName). ";\nclass ".ucfirst($baseName)." extends \\actors\\StdMenu {\n}\n")
        &&
        chmod($classPath,0666);
}

function removeBesidesRoot($str,$removeThisDir=false) {
    if (is_file($str) || is_link($str)) 
        unlink($str);
    else {
        foreach(glob("$str/*") as $path) 
            removeBesidesRoot($path,true);    
        if ($removeThisDir)    
            rmdir($str);
    }
}

function renameClass(string $old,string $new,string $dataPath) {
    [$Old,$New] = [ucfirst($old),ucfirst($new)];
    [$OldFile,$NewFile] = [DOC_ROOT."/$dataPath/$Old.php",DOC_ROOT."/$dataPath/$New.php"];
    
    $content=preg_replace('/\nclass\s+'.$Old.'/',"\nclass $New",file_get_contents($OldFile));
    $retval = file_put_contents($NewFile,$content);
    if ($retval) {
        unlink($OldFile);
        chmod($NewFile,0666);
    }
    return $retval;    //return false;

}

function renameExterns($path,$from,$to) {
    foreach ([ //
        CSS_ROOT => ['css']
       ,JS_ROOT => ['js','php']
       ] as $docRoot => $extArr) {
          
       foreach ($extArr as $ext) {
           $srcPath = "$docRoot/".substr($path,strlen(DEFCONTENT)+1);
           renameOnExists("$srcPath/$from.$ext","$srcPath/$to.$ext");
       }
   }
}

function renameOnExists(string $from,string $to,bool $ignoreExisting=true) {
    if (file_exists($from)) 
        return rename($from,$to);
    return $ignoreExisting;
}

function toTrash($file) {
    if (!file_exists($file))
        return;
    if (is_dir($file))
        $file = rtrim($file,'/');
    $to = 'trash/'.$_SESSION[LOGGEDIN].'/'.(is_dir($file) ? $file : dirname($file));
    if (!file_exists($to)) {
        mkdir($to,0777,true);
    }
    if (is_dir($file)) {
        foreach ( nodotScandir($file) as $fileInDir)
            rename("$file/$fileInDir","$to/$fileInDir");
        rmdir($file);
    } else { 
        $parmto = "$to/".basename($file);
        rename($file,$parmto);
    }
}

function trashDir($classPath) {
    foreach (glob("data/$classPath/*") as $p)
        trashReferedByDataFile(dirname($p),basename($p));
    rmdir("data/$classPath");
    // trash class
    toTrash(dirname($classPath).'/'.ucfirst(basename($classPath)).'.php');
    // rm dir of classes if previos was last
    if (count(glob(dirname($classPath.'/*')))==0) 
    rmdir(dirname($classPath));
}


/**
 * Removes a single datafile and what belongs to that datafile
 * It is not responsibly for differentiate between index or other
 * or cleanup if last data file is removed
 */
function trashReferedByDataFile(/* data/curdirstr */ $datapath,$selname) {
    $curdirstr = substr($datapath,strlen(DEFDATADIR)+1);
    $imgDir = "img/$curdirstr/".pathinfo($selname)['filename'];
        
    toTrash("$datapath/$selname"); // trash the data file
    trashSpecialExterns($curdirstr,$selname); // trash speciel externs refs
    toTrash($imgDir); // trash images
}

/**
 * special externs is refered by a datafile only - not a dir
 */
function trashSpecialExterns($path,$file) {
    $fileWOE = pathinfo($file)['filename'];
    foreach ([ //
        'css' => ['css']
       ,'js' => ['js','php']
       ] as $relDocRoot => $extArr) {
       foreach ($extArr as $ext) {
            $fileToTrash = "$relDocRoot/".substr($path,strlen(DEFCONTENT)+1)."/$fileWOE.$ext";
            if (file_exists($fileToTrash))
                toTrash($fileToTrash);
       }
   }
}

function tooglePublic() {
    $file = $_GET['file'];
    $gname = posix_getgrgid(filegroup($file))['name'];
    if ($gname !== $_SESSION[LOGGEDIN])
        return [IS_PHP_ERR,'You are not owner of '.basename($file)];
    return chmod($file,fileperms($file)^0x20)
        ? [REDRAW_DIR,'']
        : [CONFIRM_COMMAND,'unable to change group read flag'];
}

function ucAfterLast($text,$search='/') {
    $sPos = strrpos($text,$search);
    return substr($text,0,$sPos+1).ucfirst(substr($text,$sPos+1,1)).substr($text,$sPos+2);
}




/**
 * HELPER proxies that must be all outcommentet
 */
//function rename($from,$to) { return false; }
//function rename($from,$to) { return true; }
//function file_put_contents($f,$c) { return false; }
//function file_put_contents($f,$c) { return 1 /* byte */; }
//function unlink($f) { return false; }
//function unlink($f) { return true; }

function thrower() {
    $num = intval($_GET['test']);
    if ($num==1)
        throw new \Exception("ettal");
    return [IS_PHP_ERR,"called  with $num"];
}


class NNNAPI {
    use \actors\Pagefuncs;
    
    function __construct() {
        global $usesJSON;
        headerCTText();
        $usesJSON=true;
    }
    
    function edit() {
        $fileToEdit  = $_GET['filetoedit'];
        $message = $_GET['message'] ?? '_';
        file_put_contents(FILETOEDIT,"$message ".DOC_ROOT.'/'.$fileToEdit);
        echo json_encode([$fileToEdit,$_SESSION['editmode']]);
    }

    
    function emptyTrash() {
        removeBesidesRoot('trash/'.$_SESSION[LOGGEDIN]);
        echo json_encode([CONFIRM_COMMAND,'trash emptied']);
    }

    function ls() {
        $dirList = [];
        $dir = DATA_ROOT.'/'.$_GET['curdir'];
        foreach (nodotScandir($dir) as $file) {
            $fileIsDir = is_dir("$dir/$file");
            // the class that implement the files of dir or the file 
            $implClass = $fileIsDir ? ($_GET['curdir'].'/'.ucfirst("$file.php")) : ucAfterLast($_GET['curdir']).'.php';
            $dirList[] = [
                $file
                ,($fileIsDir ? '/' : '')
                ,\actors\filespec("$dir/$file")
                ,\actors\enheritChain($implClass)];
            
        }
        echo json_encode($dirList);
    }
    
    function mkDir() {
        echo json_encode(mkDDir());
    }

    function mv() {
        $srcWOE=preg_replace('/\|\w+$/','',$_GET['selname']);
        $destWOE=preg_replace('/\|\w+$/','',$_GET['txtinput']);
        $imgPathPath = IMG_ROOT.'/'.$_GET['curdir'];
        $imgSrcDir = "$imgPathPath/$srcWOE";
        $imgDestDir ="$imgPathPath/$destWOE";
        renameOnExists($imgSrcDir,$imgDestDir);
        renameExterns($_GET['curdir'],$srcWOE,$destWOE);
        $dir = DATA_ROOT.'/'.$_GET['curdir'];
        [$srcFile,$destFile] = [
            "$dir/".$_GET['selname']
            ,"$dir/".$_GET['txtinput']];
        echo json_encode([renameOnExists($srcFile,$destFile,false) 
            ? [REDRAW_DIR,''] 
            : CONFIRM_COMMAND,"$srcFile did not exist"]);
    }

    function mvDir()  {   
        $from = $_GET['selname'];
        $to = $_GET['txtinput'];
        $path = $_GET['curdir'];
        rename(DATA_ROOT."/$path/$from",DATA_ROOT."/$path/$to");
        renameClass($from,$to,$path);
        if (file_exists(/* as dir in pages/ */ DOC_ROOT."/$path/$from")) { // it would flag for inconsistence otherwise
            rename(DOC_ROOT."/$path/$from",/* new name of that dir */ DOC_ROOT."/$path/$to");
            changeNamespaceInDirs($from,$to,DOC_ROOT."/$path/$to");
        }
        $imgPathPath = IMG_ROOT.'/'.$_GET['curdir'];
        renameOnExists("$imgPathPath/$from","$imgPathPath/$to");
        renameExterns($_GET['curdir'],$from,$to);
        echo [REDRAW_DIR,''];
    }

    function newFile() {
        echo json_encode(newDFile());
    }

    function rm() {
        $selname = $_GET['selname'];
        $classPath = $_GET['curdir'];
        $group = posix_getgrgid(filegroup("data/$classPath/$selname"))['name'];
         
        if ( $group !== APACHE_USER && $group !== $_SESSION[LOGGEDIN]) {
            echo  json_encode([CONFIRM_COMMAND,$_SESSION[LOGGEDIN]." is not user of $selname"]);
            return;
        }
        if ($selname !== 'index.md' && $selname !== 'index.php' && !indexIsLinkOf("data/$classPath/$selname")) {
            trashReferedByDataFile("data/$classPath",$selname);
            echo json_encode([REDRAW_DIR,'']);
            //echo json_encode([CONFIRM_COMMAND,'remove file '.$_GET['selname']]);
        } else {
            if (hasSubDir("data/$classPath"))
                echo json_encode([CONFIRM_COMMAND,"$classPath has subdirs - delete them first"]);
            else {
                trashDir($classPath);
                //echo json_encode([CONFIRM_COMMAND,'trashdir '.$classPath]);
                echo json_encode([REDRAW_UPPERDIR,'']);
            }
        }
    }

    function rmDir() {
        $dirAsSelname = $_GET['selname'];
        $classPath = $_GET['curdir'];
        
        if (hasSubDir("data/$classPath/$dirAsSelname"))
            echo json_encode([CONFIRM_COMMAND,"$classPath/$dirAsSelname has subdirs - delete them first"]);
        else {
            trashDir("$classPath/$dirAsSelname");
            echo json_encode([REDRAW_UPPERDIR,'']);
        }
    } 

    function saveFile() {
        $content = '';
        $filename=$_POST['filetoedit'];
        $barr = unpack('C*',base64_decode(str_replace(' ','+',$_POST['content'])));
        for ($i=1; $i<count($barr); $i+=2) {
            $code = $barr[$i]+256*$barr[$i+1];
            $content .= mb_chr($code != 8629 ? $code : 10, 'UTF-8');
        }
        file_put_contents($filename,$content);
        echo "close";
    }

    function setSessionVar() {
        $key = $_GET['sessionvar'];
        $value = $_GET[$key];
        $_SESSION[$key]=$value;
        echo $value;
    }

    function test() {
        $index= 'data/'.$_GET['curdir'].'/'.$_GET['file'];
        
        
        echo json_encode([CONFIRM_COMMAND,indexIsLinkOf('data/'.$_GET['curdir'].'/'.$_GET['file'])
            ? 'index points at selected' 
            : "index do not point at selected"]);
    }

    function tooglePublic() {
        echo json_encode(tooglePublic());
    }

    function undoTrash() {
        $mes = copySubDirsOf('trash/'.$_SESSION[LOGGEDIN]) ? "trash restored - 't' for empty it" : 'some fail in trash restoring'; 
        echo json_encode([CONFIRM_COMMAND,$mes]);
    }

}
