<?php

use function actors\tocHeadline;
use function actors\tocNavigate;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>"
,tocHeadline($func,1),<<<EOMD
Edit, tast 'e' i dialog menuen gemmer navnet på filen der har fokus i config/filetoedit.txt. Med adgang til webdir kan den åbnes i editor med f.eks [wed](https://raw.githubusercontent.com/bvirk/localebin/main/wed). wed kalder [ced](https://raw.githubusercontent.com/bvirk/localebin/main/ced) som åbner i visual studio code. Filen kan også åbnes for editering i browser.
##### config/filetoedit.txt
```
$ cat config/filetoedit.txt
_ /var/www/vps/domain/data/pages/da/sysler/programmer/hocuspocus/nnnapi.php
```
$srcExpl
filetoedit.txt efter 'e' i dialog menuen på filen hvori dette står.
</div> 

filetoedit.txt har to anvendelser
- navn på fil der skal editeres
- PHP fejl message, fil og linienummer for  fejl

formatet er en linie med 2 mellemrumsadskilte felter: 
1. message encoded med '_' for mellemrum
2. filnavn eller filnavn:linienummer

EOMD,srclf('progs/NNNAPI.php','function edit','^$'),<<<EOMD
$srcExpl

Hvis det er et directory der har fokus i dialog menuen findes index deri.  
Det javascript der modtager response, åbner, betinet af værdien af \$_SESSION['editmode'], login eller hvorvidt webdir er lokalt eller ej, \$fileToEdit for editering i browser.
</div>
    



EOMD,tocNavigate($func)];