<?php
use function actors\srclf;
$filetoeditUrl=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/progs/html/source/file=config/filetoedit|txt';
$url = implode('/',$pe);
$classFile = implode('/',array_slice($pe,0,-2)).'/'.ucfirst($pe[count($pe)-2]).'.php';
$datadir = <<<EOMD
data
└── pages          
    └── da   
        ├── alterego
        │   └── index.md
        ├── index.php
        └── sysler
            └── programmer
                ├── hocuspocus
                │   ├── ajax.md
                │   └── index.md
                └── index.md
EOMD;
$pagesdir= <<<EOMD
pages
└── da
    ├── Alterego.php
    ├── sysler     
    │   ├── programmer
    │   │   └── Hocuspocus.php
    │   └── Programmer.php
    └── Sysler.php                  
EOMD;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
EOMD,srclf('index.php','require','1')
    ,srclf('globalfuncs.php','require','1')
    ,srclf('defines.php',1,2,'PAGES_ROOT','1')
    ,srclf('HocusPocus.php','abstract class','1'),<<<EOMD

### actors
Class hierarki ligger i actors. En class som instantieres af et request hvis er url starter med domain/pages/, arver fra en actors class. Navnet er en forkortelse af ancestors.  

EOMD,srclf('actors/PageAware.php','namespace','4')
    ,srclf('actors/StdMenu.php','namespace','1','class StdMenu','1'),<<<EOMD

### config
Filen valgt for editering i dialog menuen eller PHP error fanget af javascript AJAX  
[filetoedit.txt]($filetoeditUrl)

### css
Alle css filer ligger i directories der svarer til forskellige adresseringer fra url og class hierarki. 
### data
I data ligger en fil for hver html document. Url, class file og datafil hænger nøje sammen. For denne side gælder:

|           |   |           |
|:--        |:--|:--        |
|url        |∣  |$url       |
|datafile   |∣  |$incPath   |
|class File |∣  |$classFile |
|image dir  |∣  |$imgPath   | 
EOMD, srclf($incPath,'implode','2','\|:--','5'),<<<EOMD

Tree klip viser hvordan data og pages spiller sammen.

```
Directory
$datadir

Directory
$pagesdir
```
Index skal forefindes til gruppe af sider - enten som datafil index.md eller index.php eller som method.

### datavars
Datavars indeholder actor class specifik variabler til brug i datafiles. Det er html strenge som på den måde får et 'single point of source' og gør skriverier kortere.  
For denne fil:  

EOMD,srclf($dataVarsFile,1),<<<EOMD

### /etc/apache2/mods-enabled
Udover en masse almindeligt forekommende, mod_rewite - filen hedder:
-  rewrite.load 

### /etc/apache2/sites-enabled
Config file for virtualt host har en Directory sektion. Sitet __skal__ have /pages/da/index og /pages/en/index. Med disse redirections og mekanismerne i index.php og HocusPocus.php fanges enhver tænkeligt url og enten vises eller redirectes til /pages/da/index. Sidste RewriteRule er hele magien som kalder default index.php med hele path delen af url som query string parameter path værende denne.
```
<Directory /var/www/mydomain>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
RewriteEngine on
RewriteRule ^pages$ /pages/da/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=$1
</Directory>
```

### img
Hver side har sit image directory under img/ og variablen \$imgPath peger derpå. Ved sletning (trashning) af en side i dialog menuen trashes directory \$imgPath og alle filer deri.

[![imagemagick]($imgPath/imgMagicklogo.png)](https://imagemagick.org)

### js
Alle js filer ligger i directories der svarer til forskellige adresseringer fra url og class hierarki. De navne på de filer med extension js som der søges efter under skabelse af en given side, gør i deres fravær at de søges på matchene fil med php extension.  
På den måde indeholder directory js filer med extension js eller php

### jsmodules
I jsmodules ligger directory jsmodules/jslib. Filer i jslib er parameterizeret til generel anvendelse - mao. indehoder ingen kontekst fra enkelte sider eller classes.
Navnet på en sides mest nedarvede actor class er også navnet på det directory i jsmodules/ som indeholder main.js for denne actor class
EOMD,srclf('js/PageAware/StdMenu.php','use function','1','Nasty','1','module','1'),<<<EOMD

### pages
Alle sider er en side under en pages class - den som instantieres i index.php. Alle pages arver fra en actors class og indgår ikke som base class i andre pages classes.  
Det er gennem namespace kategoriseringen at url'en udpeger i en mindre delmænde af hierarkier. Pages classes er typisk tomme, indeholder blot namespace og class deklarationen udpegende base class.
Det er dog muligt at tilføre methods, men det er ikke anvendt

### progs
progs er relateret til  data/progs som pages er det til data/pages. Med samme mekanismer som for pages sider kan der hentes data og laves html documents. progs er tilænkt alt muligt andet and pages som f.eks API.  

### trash
I dialog menuen kan directories og filer i data directory slettes - dvs overføres til trash. Alt relateret der også overføres er:
- pages classes som ikke længere har data
- css og javascript som ikke længere tilhører noget
- images og img directories

Det er med komplet path, så alt der trashes 'renames' med trash/ directory foran oprindelge path fra document root
Der kan reetableres fra trash - det har fået key: 'z' i dialog menuen. Det er alt der reetableres - de enkelte trashninger forstyrrer ikke hinanden da de er distinkte.  
[/progs/emptyTrash](/progs/emptyTrash) er en magick url der tømmer trash.



### utilclasses
EOMD,srclf('utilclasses/Parsedown.php',1,12),srclf('utilclasses/Sitemap.php','class Sitemap','1','function dirlisthtml','5'),<<<EOMD
$srcExpl
Sitemap med html &lt;ul&gt; og &lt;li&gt; tags ved hjælp af recursiv nedstigning i /data/pages. Directories er links til index.  
</div>
EOMD,srclf('utilclasses/SrcLister.php',2,7,'function lines','1'),<<<EOMD
$srcExpl
Det som muliggør at vise kildekode som dette
</div>

EOMD,srclf('actors/Pagefuncs.php','showFilenameHeadEnum','6',"new \\\\utilclasses",'1','basename source','26'),actors\tocNavigate($func)];


