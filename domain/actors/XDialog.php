<?php
namespace actors;

class XDialog extends PageAware {
    protected $jsFiles= ['/js/jquery.min.js',['/jsmodules/XDialog/main.js','type' => 'module']];
    protected $useClassInheritance=false;
    protected $cssFiles= [
         ['/css/PageAware/XDialog.css?','rel' =>'stylesheet','type' => 'text/css']
        ,['/css/PageAware.css?','rel' =>'stylesheet','type' => 'text/css']];
    
    function stdContent() {
    	echo "<div id='root' data-phpErrorKey='".PHP_ERR."'></div>\n".$this->body;
	}
}
