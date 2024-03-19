<?php
namespace actors;

class XDialog extends PageAware {
    protected $jsFiles= ['/js/jquery.min.js'];
    //protected $useJSX=true;

    function stdContent() {
    	echo "<div id='root'></div>\n".$this->body;
	}
}
