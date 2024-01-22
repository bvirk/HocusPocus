<?php
namespace progs;
echo "<!-- empty trash here -->";

class EmptyTrash  {
    function index() {
        headerCTText();
        $this->emptyTheTrash('trash');
        echo "Trash Emptied\n";
    }
    function emptyTheTrash($str,$removeThisDir=false) {
        if (is_file($str)) 
            unlink($str);
        else {
            foreach(glob("$str/*") as $path) 
                $this->emptyTheTrash($path,true);    
            if ($removeThisDir)    
                rmdir($str);
        }
    }
}
