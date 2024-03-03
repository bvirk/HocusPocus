<?php
namespace actors;

class StdMenu extends PageAware {
    protected $jsFiles= ['/js/jquery.min.js'];

    function stdContent() {
    	echo "<div id='myModal' class='modal'></div>\n".$this->body;
	}
}
