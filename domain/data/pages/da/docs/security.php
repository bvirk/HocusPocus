<?php
return ["<!<div class='auto80'>#html#</div>" ,actors\tocHeadline($func),<<<EOMD
Med tidligere anviste apache configuration er directory listning blokeret af redirection - men filer der ikke er .php filer kan læses. Det gør som sådan ikke så meget da HocusPocus ikke anvender config filer, men sagen skal alligevel undersøges.  

HocusPocus kan sættes så ikke eksisterende sider bevirker redirection til default side 
EOMD,actors\srclf('HocusPocus.php','noDataAvail',3,'function noDataAvail',5),<<<EOMD
$srcExpl
Når udkommentering er sat ved developer mode redirectes ikke fundne sider til default side.
</div>

#### Directory listning
- [root](/)
    - ok. Default page grundet redirection i index.php
- [/data/pages](/data/pages)
    - redirection error
- [/config](/config)
    - redirection error

#### Ikke php filer
- [/config/filetoedit.txt](/config/filetoedit.txt)
    - synlig
- [/css/da.css](/css/da.css)
    - browser viser tom side
- [/js/da.js](/js/da.js)
    - synlig
- [/img/pages/da/docs/dirs_and_files/imgMagicklogo.png](/img/pages/da/docs/dirs_and_files/imgMagicklogo.png)
    - billede vises
- [/data/pages/da/docs/nnnapi/index.md](/data/pages/da/docs/nnnapi/index.md)
    - synlig vha. browser tilbyder at gemme
- [/jsmodules/jslib/request.js](/jsmodules/jslib/request.js)
    - synlig

### php filer
Der vurderes på de forskellige typer. functions og classes kan defineres, men uden noget udenfor functions og classes til at kalde eller instantiere, intet output.

- [/progs/EmptyTrash.php](/progs/EmptyTrash.php)
    - intet
- [/globalfuncs.php](/globalfuncs.php)
    - session sættes så loggedin user på LAN bliver USERS[/0] og default language gennem i session
- [/HocusPocus.php](/HocusPocus.php)
    - intet
- [/actors/PageAware.php](/actors/PageAware.php)
    - pga class enheritance: 'Fatal error: Uncaught Error: Class "HocusPocus" not found'
- [/actors/Pagefuncs.php](/actors/Pagefuncs.php)
    - intet
- [/config/encrypted.php](/config/encrypted.php)
    - intet
- [/data/pages/da/docs/index.php](/data/pages/da/docs/index.php)
    - intet
- [/datavars/PageAware/StdMenu.php](/datavars/PageAware/StdMenu.php)
    - intet
- [/pages/da/Docs.php](/pages/da/Docs.php)
    - pga class enheritance: 'Fatal error: Uncaught Error: Class "actors\StdMenu" not found'

### konklussion
Ingen grund til at udelukke adgang til fillæsning - for config/encrypted.php vil variablen måske i requstet eksistere i PHP, men uden noget der kan anvende dette kørselsrum bliver det ikke eksponeret.


EOMD,actors\tocNavigate($func)];