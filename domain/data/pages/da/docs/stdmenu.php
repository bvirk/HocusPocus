<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD

EOMD,srclf('actors/StdMenu.php','namespace pages',1,'class StdMenu',8),<<< EOMD
$srcExpl
hamMenu() laver html'en som anbringes før den del af body elementet som bliver layoutet fra data.
</div>

### function hamMenu()

#### Handlingen der åbner dialog menuen

EOMD,srclf('actors/StdMenu.php','id="hammenu"',1),<<< EOMD
$srcExpl
En button med et hamburger unicode tegn og navnet på funktionen der åbner dialog
</div>

EOMD,srclf('js/PageAware/StdMenu.php','allFuncs',1,"type='module'",1),<<<EOMD

EOMD,srclf('jsmodules/StdMenu/main.js','hamDrawMenu',1,'allFuncs.hamDrawMenu',1),
srclf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu',1,'myModal',1),<<<EOMD
$srcExpl
Her vises alene den css property tildeling som synliggør dialog menuen
</div>

EOMD,srclf('actors/StdMenu.php','id="myModal"',2),<<< EOMD
$srcExpl
Dialog menuens omsluttende div - indeni er html der giver den indhold.
</div>

#### Html tags indeni dialog menuen
Dialog menuen er delt op tre kolonner gennem styling.

#####variabler

EOMD,srclf('actors/StdMenu.php','isLoggedIn',3),<<< EOMD
$srcExpl
variabler for tekst og url links for login/logout.
</div>

EOMD,srclf('actors/StdMenu.php','DEFAULTEDITMODE',3),<<< EOMD
$srcExpl
Ikon for valg af om editering skal ske i browser eller ej (blot fil ref som lokal editor tilgår)
</div>

##### Venstre kolonne:
EOMD,srclf('actors/StdMenu.php','span title="Home page"',2),<<< EOMD
$srcExpl
De to span elementer - et link til roden og et tilbagelink.
</div>

EOMD,srclf('actors/StdMenu.php',"id='curDirStr'",1),<<< EOMD
$srcExpl
Path for current directory.
</div>

EOMD,srclf('actors/StdMenu.php',"id='wdFiles'",1),<<< EOMD
$srcExpl
ul element hvori javascript indsætter current directories filer
</div>

EOMD,srclf('actors/StdMenu.php',"id='statusLine'",1),<<< EOMD
$srcExpl
Statuslinie som bruges til diverse tilbagemelding og  bla. attributter for valgte fil i dir listen
</div>

EOMD,srclf('actors/StdMenu.php','form onsubmit',5),<<< EOMD
$srcExpl
Html form bliver synlig for input af fil eller dir navn for oprettelse eller omdøbning, og bekræftning eller afbrydelse for sletning af fil eller dir
</div>


##### midterste kolonne:


EOMD,srclf('actors/StdMenu.php','a href',1),<<< EOMD
$srcExpl
Login/logout link vha variabler fra linie 6
</div>


EOMD,srclf('actors/StdMenu.php','editmode:',2),<<< EOMD
$srcExpl
Og valg af edit måde vha. variabler fra linie 10
</div>

##### højre kolonne:
EOMD,srclf('actors/StdMenu.php',"id='close'",3),<<< EOMD
$srcExpl
Alene close button øverst
</div>

Det var lidt om html'en i function hamMenu(). Det forklarer intet om hvordan interaktiviteten er tilvejebragt, for det er javascript og AJAX. Før vi ser på det så en lille leg med noget simplere mekanik i næste kapitel.

EOMD,actors\tocNavigate($func)];