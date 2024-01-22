<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
Data filen index (.md eller .php) har en speciel rolle.  

Alle url paths slutter med en eksisterende method eller datafil. Enhver instantiering i index.php sker i kontekst med at afvikle den method som er url paths sidste path element. Den skal forefindes enten som method eller som datafil.  
Det er bestemt at HocusPucus ikke skal have classes som ikke kan instantieres i index.php - derfor skal alle classes, som minimum, have enten method index eller relateret datafil index

Index er default method eller datafil. I dialog menuen adresserer click på et directory, siden med method index eller datafil index. (ikke på ikonet men navnet). Det samme for filen som har focus - hvis der er et directory og der tastes return, så åbnes index siden

### Skabelse af sider
Ved skabelse af et directory i dialog menuen sker, udover oprettelsen af dir 

- index.md derunder med rudimentært standard indhold oprettes
- pages class arvende fra standard arctor class oprettes under pages/


### Slette index og directory (overføre til trash)
Sletning af index er det samme som at slette det directory hvori det ligger. Ved sletning, som er overførsel til trash, trashes alt relateret: images,css,js,php class og javascript. 

### Url med to path elementer

For pages faldet det i tre tilfælde: pages/da, pages/en og pages/whadsomhelstvolapyk - det leder alt sammen til en default side for et sprog.

Mere interessant er det for progs classes. Det bruges til at lave magick url'er som adresseres med kun to path elementer

EOMD,srclf('index.php','used for 2 path element','2'),srclf('progs/EmptyTrash.php','namespace','4'),<<<EOMD
$srcExpl
Url = progs/emptyClass idet tredje path element index bliver tilsat i index.php
</div>   

Det kan bruges til administative tools.

### Uønsket index
Som fortælling kan index være uønsket meta agtig. Der er flere ting i at lave index om til et symbolsk link til en af de andre sider.  
Det er en anden side af samme class og dermed også samme datafiles directory, der menes med 'en af de andre sider'

domain/progs/lnIndex er en magic url til at gøre det.

EOMD,srclf('progs/LnIndex.php','targetWOE','6'),<<<EOMD
$srcExpl

Skal kaldes med parameter target, men uden extension som f.eks /?path=progs/lnIndex&target=da/sysler/drama/gearkasse for at associere index med gearkasse. Der er frit valg mellem at specificere target helt fra document root eller fra data/ eller data/pages/  
Bemærk at query strings måden er nødvendig for at kalde med parametre
</div> 

EOMD,srclf('progs/LnIndex.php','link = false','20'),<<<EOMD
$srcExpl

Extension fastlægges for target og link. Skulle index i forvejen være et symbolsk link gør det ikke noget.
</div> 

EOMD,srclf('progs/LnIndex.php','function lnRel','6'),<<<EOMD
$srcExpl

PHP's symlink, når current working directory (cwd) er andet end targets directory, faciliterer ikke at lave symbolske links relativ til taget. Derfor functionen lnRel som sørger for to ting
- cwd lades urørt idet den stilles tilbage til den document root som kald af lnRel fordrer
- hvis link eksisterer i forvejen så udføres symlink ikke.
</div> 

EOMD,srclf('progs/LnIndex.php','imgDir','3'),<<<EOMD
$srcExpl

index skal også vise targets billeder
</div> 

EOMD,srclf('progs/LnIndex.php','startDir','5'),<<<EOMD
$srcExpl

Den css og javascript som gælder specielt for target skal også gælde for index.
</div> 

EOMD,actors\tocNavigate($func)];