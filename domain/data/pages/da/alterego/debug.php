<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Mange programmører har været der - man finder let vidnesbyrd derom.  

Starter med echo, var_dump og export for indkredsning af drilske fejl, i tillæg til de nødvendige php.ini indstillinger 
for at blive præsenteret for fejltyper.

Så følger nogle hjemmebryggede funktioner der gør at man også kan huske hvad der er test output.
EOMD,actors\srcf('globalfuncs.php','function varln','18'),<<<EOMD

Ved output til apaches error.log er man fri for at bryde hovedet med hvor man skal blande debug info sammen med webside indhold.
```
\$dir="data/pages";
\$name="asger";
error_log(varlnstr("dir=",\$dir,"name=",\$name));
``` 
Apaches error.log viser alt muligt som det svært for øjnene at udelukke - derfor har jeg brygget filteret [alog](https://raw.githubusercontent.com/bvirk/localebin/main/alog)

```
\$ alog
dir= 'data/pages'
name= 'asger'
```
#### Xdebug
Atter lod jeg berige med vise ord - Xdebug sammen med vscode PHP Debug gør ovenstående til fortid i vscode sammenhænge - men stadig nyttigt hvis et andet simplere PHP udviklingssystem skal sættes op. 


EOMD,actors\tocNavigate($func)];