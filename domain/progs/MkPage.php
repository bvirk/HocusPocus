<?php
namespace progs;

class MkPage {
    function index() {
        if (!array_key_exists('redir',$_GET)) {
            echo 'redir must be given';
            exit();
        }
        $_REQUEST['path'] = $_GET['redir'];
        ob_start([$this,'tidyHTML']);
        instantiatePath();
        ob_end_flush();
    }

    function tidyHTML($buffer) {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadHTML($buffer);
        $htmlLines = explode("\n",$dom->saveHTML());
        $retval='';
        $lineNum=1;
        $isInBody=false;
        $indent = 0;
        foreach ($htmlLines as $line) {
            if ($isInBody) {
                if (str_starts_with($line,' ') || strlen($line) == 0)
                    $retval .= "$line\n";
                else {
                    if (preg_match('/^<(\w+)/',$line,$tag)) {
                        $retval .= str_repeat("  ",$indent) . "$line\n";
                        $indent += preg_match("%</$tag[1]>\$%",$line,$unused) ? 0 : 1;
                    } else {
                        $indent -= preg_match('%^</\w+%',$line,$tag) && $indent > 0 ? 1 : 0;
                        $retval .= str_repeat("  ",$indent) . "$line\n";
                    }
                }
            } else {
                $retval .= "$line\n";
                $isInBody = preg_match('/^<body>$/',$line,$matches); 
            }
        }
        return $retval;
    }
    
}
