<?php
use function actors\srcf;
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
Globale variabel \$pe, som blot er \$_GET["path"] på en ny form, fastlægges i index.php
EOMD,srcf('index.php','pe = explode','1','used for 2 path element','2'),<<<EOMD
Arrayet \$pe er en forkortelse for __path elements__. Der er kun en nedre grænse for antallet af elementer - den er tre, med den undtagelse at hvis ovennævnte tildeling giver to så bliver 'index' tilføjet som tredje element.  

Indholdet i \$pe arrayet, illustreret som de path element strenge de repræsenterer:
```
\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]/\$pe[n-1]
```
#### \$pe[0] 
\$pe[0] er enten 'pages' eller 'progs'. 'pages' og 'progs' er to directories i document_root.
##### om 'pages'
Alle request som viser en side i browseren ligger i 'pages'. En constant, DEFCONTENT, har værdien 'pages'. 
##### om 'progs'
'progs' er til API og andet, faktisk også lidt der vises i browseren men indholdsmæssigt ikke kategoriseres som den type websitet budskabs informationsmæssigt favner.  


#### \$pe[0]/\$pe[1]/\$pe[2]/.../.ucfirst(\$pe[n-2].'.php'
Adresserer class som afvikler dannelsen af en af flere html sider. Class bidrager selv med html body elementet og arver, for pages vedkommende, det som danner resten af html documentet.  
&nbsp;  
&nbsp;  
#### data/\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]
Adresserer det directory hvor data filer for de sider som en class, i mangel af explicit implementererede methods, renderer body elementet med.  
&nbsp;  
&nbsp;  
#### data/\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]/\$pe[n-1] 
path til data file uden extension. Data files har extension .md eller .php (frit valg mellem syntax highligtning i editor)  
&nbsp;  
&nbsp;  
#### \$pe[n-1]
\$pe[n-1] er enten datafil eller method. \$pe[n-1] er uden den .md eller .php extension som datafil har.
&nbsp;  
&nbsp;  
#### \$pe[1] når \$pe[0] == 'pages' 
\$pe[1] kan antage en af værdierne som er key i følgende constant - og første anvendes som default.
EOMD,srcf('defines.php','LANGUAGES','1'),<<<EOMD
&nbsp;  
&nbsp;  
### Ingen 404 fortælling
I stedet for en side med en fortælling om en response code anvendes default siden.  

Et requests adressering falder i en af tre tilfælde. 

1. kald med eksisterende adresse
2. kald kun med domæne - 'path' er __ikke__ key i \$_GET
3. kald med adresse som ikke adresserer en class

##### vedr. 2
EOMD,srclf('index.php','domain only','2'),<<< EOMD

##### vedr. 3
Inkludering af class fil sker på sædvanlig php maner - ulta kort:
EOMD,srclf('index.php',11,13),<<< EOMD

Mens instantiering sker i en try catch blok

EOMD,srclf('index.php','second to last element','16'),<<< EOMD

Betinget af

EOMD,srclf('index.php','function exceptions_error_handler','4'),<<< EOMD

Opresumeret: request medfører instantiering af en  class.  
Fordi kald af class der skal afvikle requestet står i en try catch block, vil det at der kaldes en ikke eksisterende class kaste en exception i require_once php funktionenen på linie 12 i index.php - alså inde i spl_autoload_register.  

I catch delen bevirker det betinget relocation til default side.

Det som ikke fanges her i index.php, er hvorvidt en method eller datafile, alså \$pe[n-1], eksisterer. Det fanges i base class til alt der henter data - class [HocucPocus](hocuspocus)  

EOMD,actors\tocNavigate($func)];