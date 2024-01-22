<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Editoren  var jEdit. Den har syntax highlighting for en række programmeringssprog - også PHP.  

Det er en editor som er skrevet i Java og dermed har været med mig i den lange overgang til kun at anvende Linux.  

Macroer i jEdit er skrevet i java afarten Beanshell, og man hermed, integreret med editoren, adgang til alt det man kan skrive i java.  

Med en php funktion markeret kunne jeg aktivere [macro cyberkiss](https://raw.githubusercontent.com/bvirk/.jedit/master/macros/Interface/cyberkiss.bsh), hvorefter browseren åbnede siden med dens definition  på php.net

Senere porterede jeg det til et  selvstændige Beanshell program [ck](https://raw.githubusercontent.com/bvirk/localebin/main/ck) hvormed sites hvis url'er former en slags api, kan åbnes på dermed indekseret side.  

Dets wrapper [cck](https://raw.githubusercontent.com/bvirk/localebin/main/cck) anvender jeg stadig i næ, som f.eks sådan:
```
$ cck phpf preg_match
```
Når jeg har været vedholdende i at mene, at med macro cyberkiss, var jEdit [IDE](https://stackoverflow.com/questions/4672875/is-jedit-usable-as-an-ide) nok, er det nok også grundet det minimale udstyr: En Slackware 14.2 udstyret Asus eee pc.
    
Med dens afløser, en Fitlet2 MintBox, åbnede de relativt tungere youtube.com og twitter.com sig som inspirationskilde. 

Jeg erfarede at mange brugte Microsoft vscode.

Det var godt nok noget af flagskib i forhold til jEdit - og 15 år frem i tid vil jeg tro. Der er altid lykkedes mig at finde hjælp takket være flere ting - det store publikum og omfangsrige forklaringer fra et stort team bag.

PHP intelephense, php Debug og Live Sass Compiler gør det til en helt anden fornøjelse at programmere i PHP og javascript og udforme stylesheets.  

Der går lidt tid før opmærksomheden retter sig mod alle de ting man får hjælp til. 

Jeg er begyndt at finde fornøjelse i at indlede mine funktioner sådan:
EOMD,actors\srcf('actors/Pagefuncs.php','prelined markdown','6'),<<<EOMD

for så for jeg samme fine popup hjælp, med parameter angivelser, som til indbyggede PHP funktioner.

EOMD,actors\tocNavigate($func)];