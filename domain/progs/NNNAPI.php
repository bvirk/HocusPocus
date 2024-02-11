<?php

namespace progs;

use function actors\datafileExists;

function  atTopDir() {
    if ($_GET['curdir'] === 'pages') {
        echo [CONFIRM_COMMAND,'toplevel directories does not apply'];
        return true;
    }
    return false;
}

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
    file_put_contents($path,$all);
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

function hasWriteAccess($path) {
    $group = posix_getgrgid(filegroup($path))['name'];
    if ( $group == APACHE_USER || $group == $_SESSION[LOGGEDIN])
        return true;
    echo json_encode([CONFIRM_COMMAND, $_SESSION[LOGGEDIN].' is not owner of '.$_GET['selname'] ]);
    return false;
            
}

function isAUser($user) {
    if (!in_array($user,USERS)) {
        echo json_encode([CONFIRM_COMMAND,"user $user don't exists"]);
        return false;
    }
    return true;
}

function isClassDir($classPath) {
    if (file_exists($classPath)) {
        echo json_encode([CONFIRM_COMMAND, "$classPath has subdirs - delete them first"]);
        return true;
    }
    return false;
}

function isOwnerOf($path) {
    $group = posix_getgrgid(filegroup($path))['name'];
    if ( $group == $_SESSION[LOGGEDIN])
        return true;
    echo json_encode([CONFIRM_COMMAND, $_SESSION[LOGGEDIN].' is not owner of '.$path ]);
    return false;
            
}

function isLegaldataFileName() {
    extract(pathinfo($_GET['txtinput']),EXTR_PREFIX_ALL,"txtinput");
    $txtinput_ext = $txtinput_extension ?? '';
                
    if ( ($txtinput_ext !=='md' && $txtinput_ext !== 'php') || strpos($txtinput_filename,'.') !== false) {
        echo json_encode([CONFIRM_COMMAND,"file must have extension 'md' or 'php' and not contain other dots"]);
        return false;
    }
    return true;
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
    chmod($dest,0666);
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

function loggedInIsApache() {
    if (APACHE_USER !== $_SESSION[LOGGEDIN]) {
        echo json_encode([CONFIRM_COMMAND,"only for ".APACHE_USER]);
        return false;
    }
    return true;
}

/**
 * Rename including make filename index, when being a link that points to the original file or directory, 
 * a link the point to the new file or directory.
 * 
 * @param string $orgPath is the file or dir to be renamed
 * @param string $newFileWOE is filename without path or extension or name or dir without path.
 * @param bool $followExtension when true, as it deafult to, searches for possible existing link named index with same extension as  original file, when false the possible existing with extension .md or .php. 
 */
function mvInclLink(string $orgPath,string $newFileWOE,bool $followExtension=true) : void {
    extract(pathinfo($orgPath),EXTR_PREFIX_ALL,"org");
    $org_ext = isset($org_extension) ? ".$org_extension" :''; 
    $index = "$org_dirname/index";
    if ($followExtension) // both dir and file
        $index .=  $org_ext;
    else  // for datafile - index.md or index.php
        \actors\datafileExists($index);
    $newPath = "$org_dirname/$newFileWOE$org_ext";    
    if (is_link($index)) {
        unlink($index);
        \actors\lnRel($newPath,$index);
    }
    lgdIn_rename($orgPath,$newPath);
}

function newClass($file) {
    $dirName = dirname($file);
    $baseName= basename($file);
    $classPath = "$dirName/".ucfirst($baseName).'.php';
    if (!file_exists($dirName)) 
        mkdir($dirName,0777);
    file_put_contents($classPath,
        "<?php\nnamespace ".str_replace('/','\\',$dirName)
        . ";\nclass ".ucfirst($baseName)." extends \\actors\\StdMenu {\n}\n");
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
    file_put_contents($NewFile,$content);
    unlink($OldFile);
    chmod($NewFile,0666);
}

function renameExterns($path,$from,$to) {
    foreach ([ //
        CSS_ROOT => ['css']
       ,JS_ROOT => ['js','php']
       ] as $docRoot => $extArr) {
          
       foreach ($extArr as $ext) {
           $srcPath = "$docRoot/".substr($path,strlen(DEFCONTENT)+1);
           renameOnExists("$srcPath/$from.$ext",$to);
       }
   }
}

function renameOnExists(string $pathFrom,string $fileWOETo) {
    if (file_exists($pathFrom)) { 
        mvInclLink($pathFrom,$fileWOETo);
    }

}

function selectedIsIndex() {
    if (pathinfo($_GET['selname'],PATHINFO_FILENAME) == 'index') {
        echo json_encode([CONFIRM_COMMAND,'index does not apply']);     
        return true;
    }
    return false;
}

function txtinputContainsDot() {
    if (array_key_exists('extension',pathinfo($_GET['txtinput']))) {
        echo [CONFIRM_COMMAND,'dots in txtinput not allowed here'];
        return true;
    }
    return false;
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
    $index = "data/$classPath/index";
    datafileExists($index);
    trashReferedByDataFile("data/$classPath",basename($index));
    foreach (nodotScandir("data/$classPath") as $p)
        if ($p !== 'index.md' && $p !== 'index.php' )
            trashReferedByDataFile("data/$classPath",$p);
    rmdir("data/$classPath");
    // trash class
    toTrash(dirname($classPath).'/'.ucfirst(basename($classPath)).'.php');
    // rm dir of classes if previos was last
    $otherClassFiles = glob(dirname($classPath).'/*');
    if (count($otherClassFiles)== 0) 
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

    function chmod() {
        if (!loggedInIsApache())
            return;
        $selnameDataPath= 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
        $mode = intval($_GET['txtinput'],8);
        chmod($selnameDataPath,$mode);
        echo json_encode([REDRAW_DIR,'']);
    }
    
    function chown() {
        if (!loggedInIsApache() || !isAUser($_GET['txtinput']))
            return;
        $selnameDataPath= 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
        $result = chgrp($selnameDataPath,$_GET['txtinput']);
        echo json_encode([REDRAW_DIR,'']);
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
            $owner = posix_getgrgid(filegroup("$dir/$file"))['name'];
            $readFlag =  fileperms("$dir/$file") & 040;
            if (! \actors\hasReadAccessFor($owner,$readFlag,$readFlag))
                continue;
            $fileIsDir = is_dir("$dir/$file");
            $liClass = $fileIsDir ? '/Dir' : ' File';
            if ($owner == $_SESSION[LOGGEDIN])
                $liClass .= $readFlag ? 'OwnerRead' : 'OwnerNotRead';
            
            // the class that implement the files of dir or the file 
            $implClass = $fileIsDir ? ($_GET['curdir'].'/'.ucfirst("$file.php")) : ucAfterLast($_GET['curdir']).'.php';
            $dirList[] = [
                $file
                ,$liClass
                ,\actors\filespec("$dir/$file")
                ,\actors\enheritChain($implClass)];
            
        }
        echo json_encode($dirList);
    }
    
    function mkDir() {
        $txtinputPath = $_GET['curdir'].'/'.$_GET['txtinput'];
        $txtinputDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['txtinput'];
 
        if (txtinputContainsDot() || atTopDir() || !isOwnerOf($_GET['curdir']))
            return;
        lgdIn_mkdir($txtinputDataPath);
        lgdIn_copy('config/datafile',"$txtinputDataPath/index.md");
        newClass($txtinputPath);
        echo [REDRAW_DIR,''];
    }

    function mv() {
        $selname_filename=pathinfo($_GET['selname'],PATHINFO_FILENAME);
        extract(pathinfo($_GET['txtinput']),EXTR_PREFIX_ALL,"txtinput");
        $txtinput_ext = $txtinput_extension ?? '';
        $imgSelPath = 'img/'.$_GET['curdir']."/$selname_filename";
        $selDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
 
        if (!hasWriteAccess($selDataPath) || selectedIsIndex() || !isLegaldataFileName()) 
            return;
        
        renameOnExists($imgSelPath,$txtinput_filename);
        renameExterns($_GET['curdir'],$selname_filename,$txtinput_filename);
        mvInclLink($selDataPath,$txtinput_filename,false);
        echo json_encode([REDRAW_DIR,'']); 
    }

    
    // Not Testet from here
    
    function mvDir()  {   
        $selPath = $_GET['curdir'].'/'.$_GET['selname'];
        $selDataPath = "data/$selPath";
        $txtinputPath = $_GET['curdir'].'/'.$_GET['txtinput'];
        $txtinputDataPath = "data/$txtinputPath";
        $imgSelPath = 'img/'.$_GET['curdir'].'/'.$_GET['selname'];
        $imgTxtinputPath = 'img/'.$_GET['curdir'].'/'.$_GET[' txtinput'];
        
        if (!hasWriteAccess($selDataPath) || txtinputContainsDot() || atTopDir()) 
            return;
        lgdIn_rename($selDataPath,$txtinputDataPath);
        renameClass($_GET['selname'],$_GET['txtinput'],$_GET['curdir']);
        if (file_exists(/* as dir in pages/ */ $selPath  )) { 
            rename("$selPath",/* new name of that dir */ $txtinputPath);
            changeNamespaceInDirs($_GET['selname'],$_GET['txtinput'],$txtinputPath);
        }
        renameOnExists($imgSelPath,$imgTxtinputPath);
        renameExterns($_GET['curdir'],$_GET['selname'],$_GET[' txtinput']);
        echo [REDRAW_DIR,''];
    }

    function newFile() {
        $txtinputDataPath = $_GET['curdir'].'/'.$_GET['txtinput'];
 
        if (atTopDir() || !isLegaldataFileName() || !isOwnerOf($_GET['curdir']))
            return;
        lgdIn_copy('config/datafile',$txtinputDataPath);
        echo [REDRAW_DIR,''];
    }

    function rm() {
        $selDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
        if (!hasWriteAccess($selDataPath))
            return;
 
        if ($_GET['selname'] !== 'index.md' && $_GET['selname'] !== 'index.php' && !indexIsLinkOf($selDataPath)) 
            trashReferedByDataFile('data/'.$_GET['curdir'],$_GET['selname']);
        else {
            if (isClassDir($_GET['curdir']))
                return;
            trashDir($_GET['curdir']);
        }
        echo json_encode([REDRAW_UPPERDIR,'']);
    }

    function rmDir() {
        $selPath = $_GET['curdir'].'/'.$_GET['selname'];
        $selDataPath = 'data/'.$selPath;
 
        if (!hasWriteAccess($selDataPath) || isClassDir($_GET['curdir']))
                return;
        trashDir($selPath);
        echo json_encode([count(glob($_GET['curdir'].'/*')) ? REDRAW_DIR : REDRAW_UPPERDIR,'']);
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


    function tooglePublic() {
        $selDataPathDir='data/'.$_GET['curdir'];
        $selDataPath = $selDataPathDir.'/'.$_GET['selname'];
        
        if (!hasWriteAccess($selDataPath))
            return;
        $GR_xorBit = (fileperms($selDataPath) & 040)^040;
        chmod($selDataPath,(fileperms($selDataPath) & 0737) | $GR_xorBit);
        if (pathinfo($_GET['selname'],PATHINFO_FILENAME) == 'index')
            chmod($selDataPathDir,(fileperms($selDataPathDir) & 0737) | $GR_xorBit);
        echo json_encode([REDRAW_DIR,'']);
    }

    function undoTrash() {
        copySubDirsOf('trash/'.$_SESSION[LOGGEDIN]);
        echo json_encode([CONFIRM_COMMAND,'trash/'.$_SESSION[LOGGEDIN]." restored - use 't' for emptying"]);
    }

}
