<?php
namespace progs;

class Jsx extends \actors\PageAware {
    protected $jsFiles = [
         "/js/react.development.js"
        ,"/js/react-dom.development.js"
        ,"/js/babel.min.js"
    ];

    function stdContent() {
        echo $this->body;
    }
}
