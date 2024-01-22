<?php

namespace progs;

use function actors\datafileExists;

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
    $retval=true;
    if (!$rootLen)
        $rootLen=strlen($file)+1;
    if (!is_dir($file)) {
        $dest = substr($file,$rootLen);
        $destDir = dirname($dest); 
        if (!file_exists($destDir)) {
            umask(0);
            mkdir($destDir,0777,true);
        }
        $retval = is_link($file) ? rename($file,$dest) :copy($file,$dest);
    } else
        foreach (nodotScandir($file) as $fileInDir) {
            if (!copySubDirsOf("$file/$fileInDir",$rootLen))
                $retval=false;
        }
    return $retval;
}

function newClass($file) {
    $dirName = dirname($file);
    $baseName= basename($file);
    $classPath = "$dirName/".ucfirst($baseName).'.php';
    $retval=true;
    umask(0);
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
        return true;
    if (is_dir($file))
        $file = rtrim($file,'/');
    $to = 'trash/'.(is_dir($file) ? $file : dirname($file));
    if (!file_exists($to)) {
        umask(0);
        mkdir($to,0777,true);
    }
    if (is_dir($file)) {
        foreach ( nodotScandir($file) as $fileInDir)
            rename("$file/$fileInDir","$to/$fileInDir");
        return rmdir($file);
    } 
    else { // dummy else because if returns
        $parmto = "$to/".basename($file);
        return rename($file,$parmto);
    }
}

function trashDir($path) {
    $pages = glob("data/$path/*");
    $hasSubDirs=false;
    $retval=true;
    foreach ($pages as $p)
        if (is_dir($p)) {
            $hasSubDirs=true;
            break;
        }
    if ($hasSubDirs)
        return false;
    // trash Data files
    foreach ($pages as $p)
        if (!trashReferedByDataFile(dirname($p),basename($p)))
            $retval=false;
    return $retval &&
        // rm - dir that holds dat files already in trash
        rmdir("data/$path")
        &&
        // trash class
        toTrash(dirname($path).'/'.ucfirst(basename($path)).'.php')
        &&
        // rm dir of classes if previos was last
        (count(glob(dirname($path.'/*')))==0 ? true : rmdir(dirname($path)));
}


/**
 * Removes a single datafile and what belongs to that datafile
 * It is not responsibly for differentiate between index or other
 * or cleanup if last data file is removed
 */
function trashReferedByDataFile(/* data/curdirstr */ $datapath,$selname) {
    $curdirstr = substr($datapath,strlen(DEFDATADIR)+1);
    $imgDir = "img/$curdirstr/".pathinfo($selname)['filename'];
    
    return
        // trash the data file
        toTrash("$datapath/$selname")
        &&
        // trash speciel externs refs
        trashSpecialExterns($curdirstr,$selname)
        &&
        // trash images
        toTrash($imgDir);
}

/**
 * special externs is refered by a datafile only - not a dir
 */
function trashSpecialExterns($path,$file) {
    //return true;
    $fileWOE = pathinfo($file)['filename'];
    foreach ([ //
        'css' => ['css']
       ,'js' => ['js','php']
       ] as $relDocRoot => $extArr) {
          
       foreach ($extArr as $ext) {
            $fileToTrash = "$relDocRoot/".substr($path,strlen(DEFCONTENT)+1)."/$fileWOE.$ext";
            if (file_exists($fileToTrash))
                if (!toTrash($fileToTrash))
                    return false;
       }
   }
   return true;
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




class NNNAPI {
    use \actors\Pagefuncs;
    
    function __construct() {
        global $usesJSON;
        headerCTText();
        $usesJSON=true;
    }
    
    function edit() {
        $fileToEdit  = $_GET['filetoedit'];
        if (is_dir($fileToEdit))
                datafileExists($fileToEdit); // index[.md|.php]
        $message = $_GET['message'] ?? '_';
        file_put_contents(FILETOEDIT,"$message ".DOC_ROOT.'/'.$fileToEdit);
        echo json_encode([$fileToEdit,$_SESSION['editmode']]);
    }



    function emptyTrash() {
        removeBesidesRoot('trash');
        echo json_encode([IS_PHP_ERR,'trash emptied']);
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
        $file = $_GET['curdir'].'/'.$_GET['txtinput'];
        $pathInfo = pathinfo($file);
        $hasExt = array_key_exists('extension',$pathInfo);
        [$txtinputIsOk,$mes] = ($_GET['curdir'] !== 'pages' && $hasExt === false)
            ? [true,"newdir $file"] 
            : [false,'dir must below pages and without dot'];
        umask(0);
        $retval = $txtinputIsOk &&
        mkdir("data/$file") 
        &&
        chmod("data/$file",0777)
        &&
        copy('config/datafile',"data/$file/index.md")
        &&
        chmod("data/$file/index.md",0666)
        &&
        newClass($file);
        
        if (!$retval)
            $mes = "$file file creation error";
        echo json_encode([$retval && $txtinputIsOk ? 0 : IS_PHP_ERR,$mes]);
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
        echo json_encode([renameOnExists($srcFile,$destFile,false) ? 0 : IS_PHP_ERR,"$srcFile did not exist"]);
    }

    function mvDir()  {   
        $from = $_GET['selname'];
        $to = $_GET['txtinput'];
        $path = $_GET['curdir'];
        rename(DATA_ROOT."/$path/$from",DATA_ROOT."/$path/$to");
        renameClass($from,$to,$path);
        
        // if the old classname also is a dirname then rename that dir and change all namespaces recursive 
        $failMes = false;
        if (file_exists(/* as dir in pages/ */ DOC_ROOT."/$path/$from")) { // it would flag for inconsistence otherwise
            rename(DOC_ROOT."/$path/$from",/* new name of that dir */ DOC_ROOT."/$path/$to");
            changeNamespaceInDirs($from,$to,DOC_ROOT."/$path/$to");
        }
        $imgPathPath = IMG_ROOT.'/'.$_GET['curdir'];
        renameOnExists("$imgPathPath/$from","$imgPathPath/$to");
        renameExterns($_GET['curdir'],$from,$to);
        echo json_encode( [ 0, '']);
    }

    function newFile() {
        $file = $_GET['curdir'].'/'.$_GET['txtinput'];
        $ext = pathinfo($file)['extension'] ?? '';
        [$ret,$mes] = $_GET['curdir'] !== 'pages' && ($ext=='md' || $ext=='php') 
            ? [0,"newFile $file"] : [IS_PHP_ERR,'file must be .md or .php below pages'];
        if (false == ($ret == 0
                &&
                copy('config/datafile',"data/$file")
                &&
                chmod("data/$file",0666)))
            [$ret,$mes] = [IS_PHP_ERR,"could not create file: $file"];
        echo json_encode([$ret,$mes]);
    }
    
    function rm() {
        $selname = $_GET['selname'];
        $path = $_GET['curdir'];
    
        if ($selname !== 'index.md' && $selname !== 'index.php')
            echo json_encode([trashReferedByDataFile("data/$path",$selname) ? 0 : IS_PHP_ERR,"trashing $path/$selname failed"]);    
        else
            echo json_encode([trashDir($path) ? 0 : IS_PHP_ERR,"rmDir failed - perhaps subdirs"]);
    }
    
    

    function rmDir() {
        $dirAsSelname = $_GET['selname'];
        $path = $_GET['curdir'];
        
        echo json_encode([trashDir("$path/$dirAsSelname") ? 0 : IS_PHP_ERR,"rmDir failed - perhaps subdirs"]);
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

    function undoTrash() {
        $mes = copySubDirsOf("trash") ? "trash restored - 't' for empty it" : 'some fail in trash restoring'; 
        echo json_encode([IS_PHP_ERR,$mes]);
    }

}
