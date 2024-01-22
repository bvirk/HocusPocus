<?php

namespace progs;

class Html extends \actors\PageAware {
    protected $jsFiles= ['/js/jquery.min.js'];
    function stdContent() {
        echo $this->body;
    }
}
