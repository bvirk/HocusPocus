<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
StdMenu har dialogen hvormed sitet administreres. Ordet StdMenu er ved skride - det var engang en Menu som kunne noget specielt - den er efterhånden blevet mere en filemanager dialog end en menu.

EOMD,srclf('actors/StdMenu.php','namespace pages',1,'class StdMenu',8),<<< EOMD
$srcExpl

dialogen hæftes på div'en id med class="modal" vha javascript. På den måde fremtræder html'en kilden mere oerskuelig.  
Ved klik eller key enter på en side fra dialogen bliver html kilden prettyfied.
</div>

### Overførsel af context fra php til javascript

EOMD,srclf('js/PageAware/StdMenu.php','script','^$'),<<< EOMD

### Dialogens html
EOMD,srclf('jsmodules/StdMenu/main.js','let dlgHtml','^$'),<<< EOMD

#### Html tags indeni dialog menuen
Dialog menuen er delt op tre kolonner gennem styling.

##### Venstre kolonne:
EOMD,srclf('jsmodules/StdMenu/main.js','span title="Home page"',2),<<< EOMD
$srcExpl
De to span elementer - et link til roden og et tilbagelink.
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='curDirStr'",1),<<< EOMD
$srcExpl
Path for current directory.
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='wdFiles'",1),<<< EOMD
$srcExpl
ul element hvori javascript indsætter current directories filer
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='statusLine'",1),<<< EOMD
$srcExpl
Statuslinie som bruges til diverse tilbagemelding og  bla. attributter for valgte fil i dir listen
</div>

EOMD,srclf('jsmodules/StdMenu/main.js','onsubmit',6),<<< EOMD
$srcExpl
Html form bliver synlig for input af fil eller dir navn for oprettelse eller omdøbning, og bekræftning eller afbrydelse for sletning af fil eller dir
</div>


##### midterste kolonne:


EOMD,srclf('jsmodules/StdMenu/main.js',"a href",1),<<< EOMD
$srcExpl
Login/logout link vha variabler fra js/PageAware/StdMenu.php linie 22
</div>


EOMD,srclf('jsmodules/StdMenu/main.js',"editmode",2),<<< EOMD
$srcExpl
Og valg af edit måde vha. variabler fra js/PageAware/StdMenu.php linie 23
</div>

##### højre kolonne:
EOMD,srclf('jsmodules/StdMenu/main.js',"id='close'",2),<<< EOMD
$srcExpl
Alene close button øverst
</div>

Det var om html'en som 'bliver levende' som følge af javascript tilføjelser, ændringer og synliggørelser i html'en. Det udløses af keys som fanges i keyhandlers og forespørger webserveren vha AJAX og PHP. 
Først et forsøg på at forklare API på en simpel måde.  

EOMD,actors\tocNavigate($func)];