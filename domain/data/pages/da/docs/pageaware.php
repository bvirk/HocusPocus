<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
Alle sider hvis url starter med '/pages' afvikles af en class som arver indirekte fra actors\\PageAware.  

Den class som instantieres af et request er tom fordi den blot opfylder at have et namespace der passer med path af url.  
Den arver fra en class som arver fra PageAware - med andre ord -  der er mindst en class i hirakiet som ligger mellem Pageware og requestets instantierende class. 

I PageAware dannes hele html dokumentet, men property \$body outputtes ikke. PageAwares rolle er at danne tags som inkluderer css og javascript - som funktion af urlens path og det arve hierarki som subclasser PageAware.  

PageAware er også abstrakt idet den ikke implementerer stdContent(). Det er valgt for at fremtvinge beskrivende class navn(e) for layout typer.

EOMD,srclf('actors/PageAware.php','namespace pages',5),<<< EOMD

I PageAware laves hele html document.

EOMD,srclf('actors/PageAware.php','jsFiles = \[\]',4,'__construct',15,'function getExtern',1),<<<EOMD
$srcExpl

Html head og lukning af htmlen dannes i functions \_\_construct og \_\_destruct - det mangler blot en function stdContent der outputter indholdet af body elementet - hvilket en arvende class må definere.  
Method getExtern sørger for inkludering af css og javascript, i følgende gruppering

1. sammenfald mellem url og fil og directory navne i directories css/ og js/
2. sammenfald mellem class hierarki path og fil og directory navne i directories css/ og js/
3. .css .js files property arrays \$cssFiles og \$jsFiles i class som arver fra PageAware  

Når properties er protected kan getExterns() danne tags afhængigt af hvad nedarvede classes definerer 
</div>

Der er mere om hvordan getExterns() virker i et senere kapitel.

EOMD,actors\tocNavigate($func)];