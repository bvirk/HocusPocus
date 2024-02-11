<?php
use function actors\srclf;
use function actors\srcf;
return ["<!<div class='auto80'>#html#</div>"
,
    <<<EOMD
## NNNAPI
[nnn](https://github.com/jarun/nnn/wiki) er en tekst baseret linux filemanger som betjenes med tastatur og har nogle intuative taster for almindelige filoperationer.  
En af dens karakteristika er at den er menuløs og dermed let, GUI mæssigt, at efterligne som dialog menu i browser.  

Dialog menuen er javascript baseret og serviceres af NNNAPI i php.  

Det er data/pages directory tree som dialog menuen kan panorere rundt i, men fil operationer er komplekse og involverer og også css/, js/, pages/ og img/pages. Fil operationer som opret, omdøb og slet kan omfatte flere filer og/eller deres indhold - ting som ville være træls og let at gøre forkert manuelt, sikres dermed at blive gjort konsistent. 

At returnere bruges i det følgende om det, som i PHP API kildekode læses som echo - for det er, set fra den javascript function som håndterer response, en returværdi fra API kald.  

#### PHP strukturering
NNNAPI.php er den største fil i HocusPocus - og den der har undergået flest trælse omstuktureringer.  

Der anvendes ikke de gammeldags true/false returværdier i PHP filoperationer som der udmales om på php.net - det er testet at PHP 8 kan kaste kildekode linienummer dekoreret exceptions i stedet for - det er godt nok ikke vildt detaljeret med 'stat failed', men hellere det end uvisheden om korrektheden af  100'er liniers hjemmegjorte falbelader.  

Alle api kald er en method og der er ingen methods som ikke er et api kald - de fleste api kald uddelegerer til functions - void for fil operationer og boolske for selv echoende kontekst tests.  
Functions til kontekst test om brugerret og syntaks mm. er, i methods, på stribe '||' sammenstilt så den første true returværdi domino stopper og api kaldets method afsluttes idet den famøse false returnerende test har echoet beskeden der fanges af javascript.  
Det medfører en del brug af operand _not_, fordi selve testudsagnet semantisk holdes fri fra negation. Et tests returværdi er svaret på dets udsagn.
EOMD,srclf('progs/NNNAPI.php','function mv\(\)','^$'),<<<EOMD
$srcExpl

hasWriteAccess() returnerer false hvis noget underforstået ikke har skrivetilladelse til her \$selDataPath. Derfor anvendes operator '!' så der bailes ud. Der outputtes med echo i hasWriteAccess() - men kun når den returnerer false. Det betyder at den kun kan anvendes til bail out med foranstilt '!' for ellers vil javascript ikke modtage tilbagemelding om fejlagtig kontekst.  
Sådan er det med alle tests - den enkelte test skal anvendes enten med eller uden negation - men det samme altid.   
</div>

#### JavaScript response functions

API methods returnerer hvad der passer til den javascript function som modtager response. Det er et argument til kaldet af request funktionen, hvilke function som skal modtage response. Det er givet, for en bestemt API method, hvilken javascript function der modtager response fra netop den API method.

Der er 5 response functions - de starter alle med de samme 3 liner og 3 af dem med samme 4. linie som her showMenu

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function showMenu',4 ),<<<EOMD

API tilbagemelding kan deles i to grupper.
- fil listen gentegnes
- statusline meddelelse

API'er returnerer en string, et JSON encoded array af to strenge eller for dannelse af fil listens vedkommende et JSON encoded array af arrays. 




EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function catchResp','^$' ),<<<EOMD
$srcExpl

Parse error indtræffer når PHP kaster en af de fatal errors som ikke kan fanges i en exception handler. Det udskrives så i råt format på statuslinien.
</div>

IsPhpErr, redrawDir og redrawUpperDir er defineret på sider som arver af class StdMenu

```
<script>
    const isPHPErr='errOrConf';
    const redrawDir='redrawDir';
    const redrawUpperDir='redrawUpperDir';
```

EOMD,srcf('defines.php','IS_PHP_ERR',1,'CONFIRM_COMMAND',1),<<<EOMD

Disse 2 constant navne med samme værdi, bruges i PHP til 2 ting

#### Exception
EOMD,srcf('index.php','catch',10),<<<EOMD

HocusPocus har de php.ini setting der gør at functions som copy, mv, chmod, chgrp mm. som er dokumenteret på https://www.php.net/ til at kunne returne false ved fejl, aldrig gør det, men kaster en exception.  

#### Tilbagemelding om udført operation

```
echo json_encode([CONFIRM_COMMAND,'message about it']);
```

For nogle operationer er statuslinie meddelelse for meget støj idet ændringen øjeblikkeligt afspejles i fil listen eller statusliniens fil info. Sådanne operationer har denne som viderestillende response function

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function nopJSCommand','^$'),<<<EOMD

Givet disse 2 constants i PHP
EOMD,srcf('defines.php','REDRAW_DIR',1,"REDRAW_UPPERDIR",1),<<<EOMD

kan et API kan returnere en af disse som fanges af  function nopJSCommand().

```
echo json_encode([REDRAW_DIR,'']);
echo json_encode([REDRAW_UPPERDIR,'']);
```

#### \$_GET argumenter

Generelle keys i \$_GET argumentet til API methods
- 'selname'
    - betegner filen der er 'selected' i dialog menuens liste
- 'txtinput' 
    - svaret, som prompten, i en command i dialog menuen, modtager.
- 'curdir'
    - current directory for dialog menuens fil liste - den starter med pages/ og adresserer dermed fra data/ i webdir og er samtidig path i webdir for pages class.



#### Om variabel navne (mere stramt for hundrede gang - det er netop hvad programmering handler om.)

\$\_GET keys bruges som prefix til variable navne sådan som [PHP extract](https://www.php.net/manual/en/function.extract.php) laver det med EXTR_PREFIX_ALL,'_GET-key_'  

Navngivning som [PHP pathinfo](https://www.php.net/manual/en/function.pathinfo.php) bruger, anvendes
- 'basename' er 'filename' dot 'extension'
- i 'dirname', som er uden afsluttende slash, ligger 'basename' 

Følgende har relevans
- \$selname_basename
- \$selname_extension
- \$selname_filename
- \$txtinput_basename
- \$txtinput_extension
- \$txtinput_filename
- \$curdir_dirname
- \$curdir_basename

Måden de laves på er f.eks 
```
extract(\$_GET['txtinput'],EXTR_PREFIX_ALL,'txtinput');
\$txtinput_ext = \$txtinput_extension ?? ''
```
$srcExpl

txtinput_extension er fraværende hvis \$\_GET['txtinput'] intet punktum har - \$txtinput_ext oprettes da det kildekode mæssigt er kortere at bruge.  
Det anvendes til input verifikation - det er fastlagt at directories ikke må indeholde punktum og data filnavne er med extension '.md' eller '.php'
</div>

#### Sammensatte variabel navne

```
\$selPath = \$_GET['curdir'].'/'.\$_GET['selname'];
\$selDataPath = 'data/'.\$_GET['curdir'].'/'.\$_GET['selname'];
\$imgSelPath = 'img/'.\$_GET['curdir']."/\$selname_filename";
\$txtinputPath = \$_GET['curdir'].'/'.\$_GET['txtinput'];
\$txtinputDataPath = 'data/'.\$_GET['curdir'].'/'.\$_GET['txtinput'];
```

### TOC
- [edit](edit)
- [emptyTrash](emptyTrash)
- [ls](ls)
- [mkDir](mkDir)
- [mv](mv)
- [mvDir](mvDir)
- [newFile](newFile)
- [rm](rm)
- [rmDir](rmDir)
- [saveFile](saveFile)
- [setSessionVar](setSessionVar)
- [undoTrash](undoTrash)


EOMD,actors\tocNavigate('index')];