<?php
namespace utilclasses;

class Sitemap
{
    private $dirlistHtml = '';

    function hasReadAccess($path) {
        $owner = posix_getgrgid(filegroup($path))['name'];
        $readFlag =  fileperms($path) & 040;
        $readFlagDir = is_dir($path) ? $readFlag  : fileperms(dirname($path)) & 040;
        return $_SESSION[LOGGEDIN] == APACHE_USER || $owner == $_SESSION[LOGGEDIN] || ($readFlag & $readFlagDir);
    }

    function buildDirListHtml($dir,$startpos=0) {
        $leadPath='pages/';
        if (!$startpos) 
            $startpos=strlen($dir)+1;
        foreach (glob("$dir/*") as $path) {
            if (!$this->hasReadAccess($path))
                continue;
            if (is_dir($path)) {
                $finalPath = $leadPath.substr($path,$startpos).'/index';
                $look = substr($path,strrpos($path,'/')+1);
                $this->dirlistHtml .= "<li class='isDirectory'><a href='/$finalPath'>$look</a></li><ul>\n";
                $this->buildDirListHtml($path,$startpos);
                $this->dirlistHtml .= "</ul>\n";
                
            } else {
                $dotpos = strrpos($path,'.');
                $finalPath = $leadPath.substr($path,$startpos,$dotpos-$startpos);
                if (str_ends_with($finalPath,'/index') === false ) {
                    $look =substr($finalPath,strrpos($finalPath,'/')+1);
                    $this->dirlistHtml .= "<li class='isFile'><a href='/$finalPath'>$look</a></li>\n";
                }
            }
        }
    }

    
    function dirlisthtml() {
        $this->dirlistHtml = "<ul class='dirlist'>\n";
        $this->buildDirListHtml("data/pages");
        $this->dirlistHtml .= "</ul>\n";
        return $this->dirlistHtml;
    }

}
