<?php
namespace progs;

class Play extends \HocusPocus {
    protected $useMarkDown=true;
    function stdContent() {
        echo $this->body;
    }
    function myMethod() {
        echo "Hello ".($_GET['name'] ?? 'nobody')."\n";
    }
}
