<?php

namespace progs;
use utilclasses\Parsedown;
use function actors\datafileExists;
use function actors\pageExternsOfType;

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

function changeNamespaceInDirs(string $old,string $new,string $path) { 
    foreach (glob("$path/*") as $file)
        if (is_dir($file)) {
            changeNamespaceInDirs($old,$new,$file);
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

function cssOrJsHelp() {
    $content = <<<EOMD
#### Css og Js navigering

|               |                                       |
|:--            |:--                                    |
|e              |rediger fil                            |
|q              |afslut hjælp                           |
|x              |flyt fil                               |
|y              |confirm flyt til mappen trash          |
|pile taster    |naviger rundt                          |
|Esc            |                                       |
EOMD;
    return (new Parsedown())->text($content);
}

function imgHelp() {
    $content = <<<EOMD
#### Image navigering

|               |                  |       
|:--            |:--               |       
|q              |quit this help    |        
|u              |Upload image     |
|x              |thash file       |
|y              |confirm trashing |
|Arrows ↨       |pan up or down    |     
|Esc            |quit this help    |       
EOMD;
    return (new Parsedown())->text($content);
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

function navHelp() {
    $content = <<<EOMD
#### Datafiler navigering

|               |                                       |
|:--            |:--                                    |
|F9             |menu                                   |
|c              |skift mellem synlig og skjult          |
|e              |rediger fil                            |
|h              |aktivere kontekstuel hjælp             |
|m              |ændre tilladelser                      |
|n              |ny fil eller dir                       |
|o              |skift ejerskab                         |
|r              |omdøb fil eller dir                    |
|q              |afslut menu                            |
|t              |tøm mappen trash                       |
|x              |flyt fil eller dir til mappen trash    |
|y              |confirm flyt til mappen trash          |
|z              |reetabler alt fra mappen trash         |
|pile taster    |naviger rundt                          |
|Esc            |afslut eller fortryd                   |
|Enter          |vælg side                              |
|Home           |standard side                          |
EOMD;
    return (new Parsedown())->text($content);
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
    [$OldFile,$NewFile] = ["$dataPath/$Old.php","$dataPath/$New.php"];
    
    $content=preg_replace('/\nclass\s+'.$Old.'/',"\nclass $New",file_get_contents($OldFile));
    file_put_contents($NewFile,$content);
    unlink($OldFile);
    chmod($NewFile,0666);
}

function renameExterns($path,$from,$to) {
    foreach ([ //
        'css' => ['css']
       ,'js' => ['js','php']
       ] as $docRoot => $extArr) {
          
       foreach ($extArr as $ext) {
           $srcPath = "$docRoot/".substr($path,strlen(DEFCONTENT)+1);
           renameOnExists("$srcPath/$from.$ext",$to);
       }
   }
}

function renameExternsDir() {
    $extCurDir = substr($_GET['curdir'],1+strlen(DEFCONTENT));
    foreach (['css','js'] as $extRoot) {
        $from = "$extRoot/$extCurDir/".$_GET['selname'];
        $to = "$extRoot/$extCurDir/".$_GET['txtinput'];
        if (file_exists($from))
            rename($from,$to);
    }
}

function renameOnExists(string $pathFrom,string $fileWOETo) {
    if (file_exists($pathFrom)) { 
        mvInclLink($pathFrom,$fileWOETo);
    }

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

function travChGrp($path,$newGrp,$ifGrp='') {
    if ($ifGrp == '')
        $ifGrp=posix_getgrgid(filegroup($path))['name'];
    $isOrgGrp = posix_getgrgid(filegroup($path))['name'] == $ifGrp;
    if (is_dir($path) && $isOrgGrp) {
        chgrp($path,$newGrp);
        foreach (glob("$path/*") as $file)
            travChGrp($file,$newGrp,$ifGrp);
    } else
        if ($isOrgGrp) 
            chgrp($path,$newGrp);
}

class NNNAPI {
    use \actors\Pagefuncs;

    private $dirProps = [
         'file' => 'file'
        ,'styleClass' => 'styleClass'
        ,'isDir' => 'isDir'
        ,'isIndexTarget' => 'isIndexTarget'
        ,'desc' => 'desc'
        ,'dirHasDir' => 'dirHasDir'
        ,'enheritClass' => 'enheritClass'
        ,'filePermstat' => 'filePermstat'
        ,'eFlag' => 'eFlag'
        ,'someDirHasDir' => 'someDirHasDir'
        ,'permstat' => 'permstat'
        ,'dirlist' => 'dirlist'
    ];

    function __construct() {
        global $usesJSON;
        headerCTText();
        $usesJSON=true;
    }

    function chmod() { // checked0227
        $selnameDataPath= 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
        $mode = intval($_GET['txtinput'],8);
        chmod($selnameDataPath,$mode);
        echo json_encode([REDRAW_DIR,'']);
    }

    function chown() { // checked0227
        $selnameDataPath= 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
        travChGrp($selnameDataPath,$_GET['txtinput']);
        echo json_encode([REDRAW_DIR,'']);
    }

    function du() {
        $usage = \actors\du($_POST['file']);
        echo json_encode([__FUNCTION__ => ['usage' => \actors\formatBytes($usage) ]]);
    }

    function edit() { // checked0227
        $fileToEdit  = $_GET['filetoedit'];
        $message = $_GET['message'] ?? '_';
        if (!file_exists($fileToEdit)) { //css or js files
            if (!file_exists(dirname($fileToEdit))) {
                $oldM = umask(0);
                mkdir(dirname($fileToEdit),0777,true);
                umask($oldM);
            }
            touch($fileToEdit);
            chmod($fileToEdit,0666);
        }
        file_put_contents(FILETOEDIT,"$message ".$_SERVER['DOCUMENT_ROOT'].'/'.$fileToEdit);
        echo json_encode([$fileToEdit,$_SESSION['editmode']]);
    }

    function editObj() {
        $fileToEdit  = $_POST['filetoedit'];
        $message = $_POST['message'] ?? '_';
        if (!file_exists($fileToEdit)) { //css or js files
            if (!file_exists(dirname($fileToEdit))) {
                $oldM = umask(0);
                mkdir(dirname($fileToEdit),0777,true);
                umask($oldM);
            }
            touch($fileToEdit);
            chmod($fileToEdit,0666);
        }
        file_put_contents(FILETOEDIT,"$message ".$_SERVER['DOCUMENT_ROOT'].'/'.$fileToEdit);
        echo json_encode([$fileToEdit,$_SESSION['editmode']]);
    }

    function emptyTrash() {
        removeBesidesRoot('trash/'.$_SESSION[LOGGEDIN]);
        echo json_encode([CONFIRM_COMMAND,'trash emptied']);
    }
    
    function emptyObjTrash() {
        $userTrash = 'trash/'.$_SESSION[LOGGEDIN];
        $bef = \actors\du($userTrash);
        removeBesidesRoot('trash/'.$_SESSION[LOGGEDIN]);
        $after = \actors\du($userTrash);
        echo json_encode([__FUNCTION__ => ['released' => \actors\formatBytes($bef-$after)]]);
    }

    function help() { // checked0227
        $typeHelpFunc = __NAMESPACE__.'\\'.$_GET['type'].'Help';
        $content = $typeHelpFunc();
        echo json_encode(['',(new Parsedown())->text($content)]);
    }

    function ls() { // checked0227
        $dirList = [];
        $dir = 'data/'.$_GET['curdir'];
        $dirHasDir=false;
        foreach (nodotScandir($dir) as $file) {
            $owner = posix_getgrgid(filegroup("$dir/$file"))['name'];
            $readFlag =  fileperms("$dir/$file") & 040;
            if (! \actors\hasReadAccessFor($owner,$readFlag,$readFlag))
                continue;
            $fileIsDir = is_dir("$dir/$file");
            if ($fileIsDir)
                foreach( glob("$dir/$file/*") as $fileOfDir)
                    if (is_dir($fileOfDir))
                        $dirHasDir=true;
            $liClass = $fileIsDir ? '/Dir' : ' File';
            if ($owner == $_SESSION[LOGGEDIN])
                $liClass .= $readFlag ? 'OwnerRead' : 'OwnerNotRead';
            
            // the class that implement the files of dir or the file 
            $implClass = $fileIsDir ? ($_GET['curdir'].'/'.ucfirst("$file.php")) : ucAfterLast($_GET['curdir']).'.php';
            $dirList[] = [
                $file
                ,$liClass
                ,\actors\filespec("$dir/$file")
                ,\actors\enheritChain($implClass)
                , $owner == $_SESSION[LOGGEDIN] | ($_SESSION[LOGGEDIN] == APACHE_USER) *2];
            
        }
        echo json_encode([$dirHasDir,\actors\permStat($dir),$dirList]);
    }

    function lsWithPath() {
        
        $dirList = [];
        $dir = $_POST['curdir'];
        $someDirHasDir=false;
        $d = $this->dirProps;
        $indexFile = "$dir/index";
        \actors\datafileExists($indexFile);
        $indexLink = is_link($indexFile) ? readlink($indexFile):'';
        foreach (glob($dir.($dir?'/*':'*')) as $fileWP /* webroot path */) {
            $owner = posix_getgrgid(filegroup($fileWP))['name'];
            $readFlag =  fileperms($fileWP) & 040;
            if (! \actors\hasReadAccessFor($owner,$readFlag,$readFlag))
                continue;
            $fileIsDir = is_dir($fileWP);
            $styleClass = $fileIsDir ? 'Dir' : 'File';
            if ($owner == $_SESSION[LOGGEDIN])
                $styleClass .= $readFlag ? 'Vis' : 'Hid';
            
            // the class that implement the files of dir or the file 
            if (str_starts_with($dir,'data/pages/')) {
                $classPath = substr($dir,5);
                $file = substr($fileWP,strrpos($fileWP,'/')+1);
                $implClass = $fileIsDir 
                    ? ("$classPath/".ucfirst("$file.php")) 
                    : ucAfterLast($classPath).'.php';
                $enhChn = \actors\enheritChain($implClass);
            } else
                $enhChn = '';
            
            $dirHasDir = false;
            if ($fileIsDir) {
                foreach( glob("$fileWP/*") as $fileOfDir)
                    if (is_dir($fileOfDir)) {
                        $dirHasDir = true;
                        $someDirHasDir=true;
                        break;
                    }
            }
            
            
            $dirList[] = [
                 $d['file'] => $fileWP
                ,$d['styleClass'] => $styleClass
                ,$d['isDir'] => $fileIsDir
                ,$d['isIndexTarget'] => basename($fileWP) === $indexLink ? 'index link target' : null
                ,$d['desc'] => \actors\filespec($fileWP)
                ,$d['dirHasDir'] => $dirHasDir 
                ,$d['enheritClass'] => $enhChn
                ,$d['filePermstat'] => $owner == $_SESSION[LOGGEDIN] | ($_SESSION[LOGGEDIN] == APACHE_USER) *2];
            
        }
        echo json_encode([
             $d['someDirHasDir'] => $someDirHasDir
            ,$d['permstat'] => \actors\permStat($dir)
            ,$d['dirlist']=> $dirList]);
    }


    function lsExt() { // checked0227
        $selDataPath = $_GET['selDataPath'];
        $type = $_GET['type'];
        echo json_encode(pageExternsOfType($type,$selDataPath));
    }

    function lsObjExt() { 
        $d = $this->dirProps;
        $selDataPath = $_POST['selDataPath'];
        $type = $_POST['type'];
        $keyedFilespec = [];
        foreach (pageExternsOfType($type,$selDataPath) as $fileSpec)
            $keyedFilespec[] = [$d['file'] => $fileSpec[0],$d['eFlag'] => $fileSpec[1],$d['desc'] => $fileSpec[2]]; 
        echo json_encode([$d['dirlist'] => $keyedFilespec]);
    }

    function mkDir() { // checked0227
        $txtinputPath = $_GET['curdir'].'/'.$_GET['txtinput'];
        $txtinputDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['txtinput'];
 
        lgdIn_mkdir($txtinputDataPath);
        lgdIn_copy('config/datafile',"$txtinputDataPath/index.md");
        newClass($txtinputPath);
        echo json_encode([REDRAW_DIR,'']);
    }

    function mkObjDir() { // checked0227
        $dirOfNewDir = $_GET['dir'];
        $newDir = "$dirOfNewDir/".$_GET['txtinput'];
        foreach (["$dirOfNewDir/pageScheme","$dirOfNewDir/index"] as $srcFile)
            if (\actors\datafileExists($srcFile))
                break;
        $destFile = 'index.'. pathinfo($srcFile,PATHINFO_EXTENSION);
        lgdIn_mkdir($newDir);
        lgdIn_copy($srcFile,"$newDir/".basename($destFile));
        newClass(substr($newDir,/* without leading data/ */ 5)); 
        echo json_encode([__FUNCTION__ => ['index copied from' => $srcFile] ]);
    }

    function mv() { // checked0227
        $selname_filename=pathinfo($_GET['selname'],PATHINFO_FILENAME);
        extract(pathinfo($_GET['txtinput']),EXTR_PREFIX_ALL,"txtinput");
        $txtinput_ext = $txtinput_extension ?? '';
        $imgSelPath = 'img/'.$_GET['curdir']."/$selname_filename";
        $selDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
 
        renameOnExists($imgSelPath,$txtinput_filename);
        renameExterns($_GET['curdir'],$selname_filename,$txtinput_filename);
        mvInclLink($selDataPath,$txtinput_filename,false);
        echo json_encode([REDRAW_DIR,'']); 
    }

    function mvImg() { // checked0228
        $selname=$_GET['selname'];
        $txtinput=$_GET['txtinput'];
        rename($selname,dirname($selname)."/$txtinput");
        echo json_encode([REDRAW_IMG_DIR,'']); 
    }

    function mvDir()  {   // checked0228
        $selPath = $_GET['curdikr'].'/'.$_GET['selname'];
        $selDataPath = "data/$selPath";
        $txtinputPath = $_GET['curdir'].'/'.$_GET['txtinput'];
        $txtinputDataPath = "data/$txtinputPath";
        
        lgdIn_rename($selDataPath,$txtinputDataPath);
        renameClass($_GET['selname'],$_GET['txtinput'],$_GET['curdir']);
        if (file_exists(/* as dir in pages/ */ $selPath  )) { 
            rename("$selPath",/* new name of that dir */ $txtinputPath);
            changeNamespaceInDirs($_GET['selname'],$_GET['txtinput'],$txtinputPath);
        }
        renameOnExists('img/'.$_GET['curdir'].'/'.$_GET['selname'],$_GET['txtinput']);
        renameExternsDir();
        echo json_encode([REDRAW_DIR,'']);
    }

    function newFile() { // checked0228
        $txtinputDataPath = $_GET['curdir'].'/'.$_GET['txtinput'];
        lgdIn_copy('config/datafile',"data/$txtinputDataPath");
        echo json_encode([REDRAW_DIR,'']);
    }

    function newObjFile() { // checked0228
        $dir = $_GET['dir'];
        $newFile = "$dir/".$_GET['txtinput'];
        foreach (["$dir/pageScheme","$dir/index"] as $orgFile)
            if (\actors\datafileExists($orgFile))
                break;
        lgdIn_copy($orgFile,$newFile);
        echo json_encode([__FUNCTION__ => ['index source' => $orgFile]]);
    }

    function pageContext() {
        $all = [
            'SES'             => $_SESSION
           ,'DEFAULTEDITMODE' => DEFAULTEDITMODE
           ,'APACHE_USER'     => APACHE_USER        
           ,'REDRAW_DIR'      => REDRAW_DIR
           ,'REDRAW_IMG_DIR'  => REDRAW_IMG_DIR
           ,'REDRAW_UPPERDIR' => REDRAW_UPPERDIR
        ];
        foreach ($this->dirProps as $k => $v)
            $all[$k] = $v;
        echo json_encode($all);

       //echo json_encode([PHP_ERR => "This is an intendede php error"]);
    }
        
    function recievePost() {
        //foreach ($_POST as $key => $val)
        $cnt = '';
        echo json_encode([__FUNCTION__ => count($_POST)]);
    }

    function rm() {
        $selDataPath = 'data/'.$_GET['curdir'].'/'.$_GET['selname'];
 
        if ($_GET['selname'] !== 'index.md' && $_GET['selname'] !== 'index.php' && !indexIsLinkOf($selDataPath)) 
            trashReferedByDataFile('data/'.$_GET['curdir'],$_GET['selname']);
        else 
            trashDir($_GET['curdir']);
        
        echo json_encode([REDRAW_UPPERDIR,'']);
    }

    function rmObj() {
        $dir = dirname($_GET['file']);
        $basefile = basename($_GET['file']);
        trashReferedByDataFile($dir,$basefile);
        echo json_encode(['succes' =>__FUNCTION__ ]);
    }

    function rmDir() {
        $selPath = $_GET['curdir'].'/'.$_GET['selname'];
        $selDataPath = 'data/'.$selPath;
 
        trashDir($selPath);
        echo json_encode([count(glob($_GET['curdir'].'/*')) ? REDRAW_DIR : REDRAW_UPPERDIR,'']);
    } 

    function rmObjDir() {
        trashDir($_GET['file']);
        echo json_encode([ __FUNCTION__ => ['trashed' => $_GET['file']] ]);
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

    function sessionVar() {
        $key = $_GET['sessionvar'];
        $value = $_GET[$key];
        $_SESSION[$key]=$value;
        echo json_encode([$key => $value]);
    }

    function setSessionVar() {
        $key = $_GET['sessionvar'];
        $value = $_GET[$key];
        if ($value == 'unset')
            unset($_SESSION[$key]);
        else
            $_SESSION[$key]=$value;
        echo json_encode([$_GET['item0'] ?? '',$value]);
    }

    function test() {
        $d = $this->dirProps;
        $all = [
             'SES'             => $_SESSION
            ,'DEFAULTEDITMODE' => DEFAULTEDITMODE
            ,'APACHE_USER'     => APACHE_USER        
            ,'REDRAW_DIR'      => REDRAW_DIR
            ,'REDRAW_IMG_DIR'  => REDRAW_IMG_DIR
            ,'REDRAW_UPPERDIR' => REDRAW_UPPERDIR
            ,$d['fileK'] => $d['fileK']
        ];
        foreach ($this->dirProps as $k => $v)
            $all[$k] = $v;
        echo json_encode($all);
    }

    function tooglePublic() {
        header('Access-Control-Allow-Origin: *');
        $selDataPathDir='data/'.$_GET['curdir'];
        $selDataPath = $selDataPathDir.'/'.$_GET['selname'];
        


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

    function undoObjTrash() {
        $userTrash = 'trash/'.$_SESSION[LOGGEDIN];
        copySubDirsOf($userTrash);
        $userUsage = \actors\du($userTrash);
        
        echo json_encode([__FUNCTION__ => \actors\formatBytes($userUsage-4096). '' ]);
    }

    function viewSessionVars() {
        $out='';
        foreach ($_SESSION as $k => $v)
            $out .= "$k=>$v, ";
        echo "\"$out\"";
        
    }


}
