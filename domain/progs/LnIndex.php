<?php
namespace progs;


class LnIndex  {
    function index() {
        headerCTText();
        if (!array_key_exists('target',$_GET)) {
            echo "target must me given\n";
            return;
        }
         $targetWOE =$_GET['target'];
         $targetWOE = str_starts_with($targetWOE,'data/') 
            ? $targetWOE 
            : (str_starts_with($targetWOE,'pages/') 
                ? "data/$targetWOE" 
                : "data/pages/$targetWOE");  
        $link = false;
        $target = false;
        foreach (['.md','.php'] as $ext) {
            if (file_exists("$targetWOE$ext"))
                $target= "$targetWOE$ext";
            if (file_exists(dirname($targetWOE)."/index$ext"))
                $link = dirname($targetWOE)."/index$ext";
        }
        if (!$target) {
            echo "target did not exist";    
            return;
        }
        if (!$link) {
            echo "no index found";
            return;
        }
        if (!is_link($link)) {
            unlink($link);
            \actors\lnRel($target,$link);
        }
        $imgDir = 'img/'.substr($targetWOE,5);
        if (file_exists($imgDir))
            \actors\lnRel($imgDir,dirname($imgDir).'/index');
        
        foreach (['css/' => ['.css'],'js/' => ['.js','.php']] as $startDir => $extArr)
            foreach ($extArr as $ext) {
                $target = $startDir.substr($targetWOE,11).$ext;
                if (file_exists($target))
                \actors\lnRel($target,dirname($target).'/index'.$ext);
            }
        echo "$link points to $targetWOE\n";
    }
}
