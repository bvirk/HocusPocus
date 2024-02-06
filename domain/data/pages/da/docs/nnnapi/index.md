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

#### Response functions

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

IsPhpErr og redrawDir er defineret på sider som arver af class StdMenu

```
 <script>
   const isPHPErr='errOrConf';
   const redrawDir='redrawDir';
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

Og API kan blot returnere dette som fanges af function nopJSCommand().

```
echo json_encode([REDRAW_DIR,'']);
```

#### \$_GET argumenter

Generelle keys i \$_GET argumentet til API methods
- 'selname'
    - betegner filen der er 'selected' i dialog menuens liste
- 'txtinput' 
    - svaret, som prompten, i en command i dialog menuen, modtager.
- 'curdir'
    - current directory for dialog menuens fil liste - den starter med pages/ og adresserer dermed fra data/ i webdir og er samtidig path i webdir for pages class.

#### Om variabel navne

- Postfix WOE i variabel navn for 'without extension'.

url encoding
- '|' er en encoding af '.' i url.



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