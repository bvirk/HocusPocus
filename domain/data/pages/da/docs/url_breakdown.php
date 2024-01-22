<?php
$rewriteReplWOP='?path=\$1';

use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
Den del af en url som kommer efter domæne kaldes dens path. Path er jo også noget enhver fil og directory har, så nogle gange vil path bruges om andet end path delen af url.

### To adresseringsmåder

- [/$classPath/$func](/$classPath/$func)
- [/?path=$classPath/$func](/?path=$classPath/$func)

Den første bruges for at få pæne genbrugbare url'er i browserens adresse linie - den sidste hvor det skal være muligt at overføre parametre. Den første er med anvendelsen mod_rewite, den sidste er query string måden. API'er og kildekode viseren anvender query string.

Den pæne url path er lavet med denne apache webserver regel:
```
RewriteRule ^([\w+/]+)$ ?path=\\$1
```
Der er den udfordring, at hvis hele den path der requestes, er et directory, så vil query string path ganske vist blive korrekt, men requestet bliver foranstillet dette directory - altså rettet mod en index.php som __ikke__ ligger i document root men i request path directory - og det er ikke ideen!

Problemet løses med redirection.

For at gøre det let at udforske effekten af redirection har index.php disse linier
EOMD,srclf('index.php','Uncomment for inspection','2'),<<<EOMD

Redirection retter sig mod path 'pages', fordi alle websider i HocusPokus starter med 'pages'.  

```
...
RewriteRule ^pages$ /pages/da/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^pages/en$ /pages/da/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=\\$1
...
```
Sammen med den redirection der er i index.php's kildekode, oplister følgende de tilfælde der __ikke__  viser Apaches lidet værdsatte 'siden kan ikke vises' eller anden url error info
- det nøgne domæne [/](/)
- et af sprogvalgende som  [/da](/da) eller [/en](/en)
- [/pages/da](/pages/da) eller [/pages/en](/pages/en), fordi man kunne tro at det var nødvendigt at skrive sådan.
- [/pages](/pages)
- [/pages/volapyk](/pages/volapyk)
- [/volapyk](/volapyk) som ikke er et directory

Der er valgt ikke at redirecte ethvert directory træ forgrening i document root. 

### Relative links
Relative links, som data indholdet gør brug af, er afhængigt af path ikke afslutter med slash
EOMD,srclf('index.php','We dont allow url','3'),<<<EOMD
$srcExpl

Det er nødvendigt med redirection, da det bestemmer hvordan browseren definerer relative links.
</div>


### [.htaccess kontra apaches VirtualHost config fil](http://httpd.apache.org/docs/2.4/howto/htaccess.html#when)
Ovennævnte link argumenterer mod at anvende .htaccess. Et argument går på fil læsninger ved directory tilbage trevling som ikke gælder her hvor det altid er index.php som kaldes. Det kræver dog altid en ekstra .htacces fil læsning pr request, men hvis en hostning ikke tillader adgang til apaches config fil, kan det blive nødvendigt at anvende .htaccess

EOMD,actors\tocNavigate($func)];