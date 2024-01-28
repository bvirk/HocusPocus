<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
, actors\tocHeadline($func), 
    <<<EOMD
Javascript kan via AJAX hente fra webserveren - ligesom et request fra browseren henter text, henter AJAX text - der er så valgt at returnere JSON i modsætning til html - fordi javascript kan parse JSON.

Der er lavet en mere fleksibel måde at danne &lt;script&gt;'s på, end det der gælder for css's &lt;link&gt;  

For en given en url, kigges der efter en mængde filnavne der ender med .js. Der hvor der ikke findes en .js fil, kigges der efter en .php fil. Med det er disse muligheder tilvejebragt:
- flere javascript filer knyttet til den enkelte adresserings path
- direkte javascript for injektering af kontekst
- type='module' attribute i &lt;script&gt;'s

EOMD,srclf('data/progs/html/apifortunes.md',1),<<<EOMD


EOMD,srclf('js/html/apifortunes.php',1),<<<EOMD
$srcExpl
isPhpErr danner en bro mellem PHP og javascript - det som en exception i php sender.
</div>

EOMD,srclf('jsmodules/FortunesAPI/main.js',1),<<<EOMD
$srcExpl
Ved at tildele funktionen som defineres i linie 2-4, variabelen windows.coloredFortune, kan den kaldes fra &lt;button&gt; onClick attributten 'coloredFortune();'  

setFortune() modtager httpRequest.responseText. Der differentieres mellem

- et ok parsed json object
    - signaleret fejl operation - PHP exception som er blivet gemt i file og her alert(php exception message) 
    - ikke signaleret fejl - resultatet anvendes blot til farve en visdoms sætning
- parse error indikerende PHP fejl som ikke har kastet PHP exeption
- anden error som må være javascript error i større setup 
</div> 

EOMD,srclf('jsmodules/jslib/request.js',2,14),<<<EOMD
$srcExpl
I httpRequest.open(...), parametre 'fortunesAPI', 'fortune' og '' for henholdsvis class, method og args, bliver til kald af method fortune i /progs/fortunesAPI.  

Funktionen som skal modtage svaret tildeles httpRequest.onreadystatechange - det er funktion setFortune() i jsmodules/FortunesAPI/main.js hvis navn  var sidste parameter i kald til request(...) 
</div>

[fortunes Using API](/progs/html/apifortunes), [fortunes using API med fejl](/?path=progs/html/apifortunes&mkErr=%26mkErr) 

EOMD,actors\tocNavigate($func)];