<?php
namespace actors;




class Simply extends PageAware {
    
    function stdContent() {
        echo $this->body;
	}
}
