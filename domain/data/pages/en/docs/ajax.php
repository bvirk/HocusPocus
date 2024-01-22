<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
For a given url, a set of filenames ending in .js is looked for. Where there is no .js file, a .php file is looked for. With that, these options are provided:
- several javascript files linked to the individual addressing path
- direct javascript for injecting context
- type='module' attribute in script tag

EOMD,srclf('data/progs/html/apifortunes.md',1),<<<EOMD

EOMD,srclf('js/html/apifortunes.php',1),<<<EOMD
$srcExpl
isPhpErr forms a bridge between PHP and javascript - it is what an exception in php sends.
</div>

EOMD,srclf('jsmodules/FortunesAPI/main.js',1),<<<EOMD
$srcExpl
By assigning the function defined in lines 2-4 to the variable windows.coloredFortune, it can be called from &lt;button&gt; onClick attribute 'coloredFortune();'

setFortune() recieves httpRequest.responseText. A distinction is made among:

- an ok parsed json object
    - signaled error operation - PHP exception which is saved in the file and, in this fortune demo, alert(php exception message)
    - not signaled error - the result is simply used to color a sentence of wisdom
- parse error indicating a PHP error that has not thrown a PHP exception
- other error which must be javascript error in larger setup</div> 

EOMD,srclf('jsmodules/jslib/request.js',2,14),<<<EOMD
$srcExpl
In httpRequest.open(...), parameters 'fortunesAPI', 'fortune' and '' for class, method and args, respectively, become calls to method fortune in /progs/fortunesAPI.  

The function that must receive the response is assigned httpRequest.onreadystatechange - it is function setFortune() in jsmodules/FortunesAPI/main.js whose name was the last parameter in the call to request(...)
</div>

[fortunes Using API](http://p.ps/progs/html/apifortunes), [fortunes using API with php error](http://p.ps/?path=progs/html/apifortunes&mkErr) 


EOMD,actors\tocNavigate($func)];