<?php
errLog(get_defined_vars());
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Mange programmører har været der - man finder let vidnesbyrd derom.  

Starter med echo, var_dump og export for indkredsning af drilske fejl, i tillæg til de nødvendige php.ini indstillinger 
for at blive præsenteret for fejltyper.

Problemmet er at man skal overveje hvor debug output skal vises - det er sådan set let nok - men der skal tages stilling og skrives noget - lidt besværligt for blot at fange en tanketorsk.

Ved output til apaches error.log er man fri for at bryde hovedet med hvor man skal blande debug info sammen med webside indhold.

EOMD,actors\srclf('globalfuncs.php','function errLog','^$','function varLnStr','^$','function varsStr','^$'),<<<EOMD

Når funktionaliteten er sådan i hinanden indlemmet, er det fordi function varsStr også kan bruges med denne wrapper til info på websider

EOMD,actors\srclf('globalfuncs.php','function varBrStr','^$'),<<<EOMD

Tilbage til anvendelsen af function errLog - første ønske kunne være, på en givet sted i en function, at se værdien af alle lokale variabler 

```
function myFunc() {
...
errLog(get_defined_vars());
...
```

Apaches error.log viser alt muligt som det svært for øjnene at udelukke - derfor filteret [alog](https://raw.githubusercontent.com/bvirk/localebin/main/alog)  

Følgende er terminal output efter request med linien 'errLog(get_defined_vars());' før return statement i datafilen for denne side.

```
\$ alog
func: 'debug'
funcArgsArray: array[]
pe: 0: 'pages'
1: 'da'
2: 'alterego'
3: 'debug'
classPath: 'pages/da/alterego'
imgPath: '/img/pages/da/alterego/debug'
incPath: 'data/pages/da/alterego/debug.php'
dataVarsFile: 'datavars/PageAware/StdMenu.php'
srcExpl: '<div class='srcExpl'>'
clearLeft: '<p class='clearLeft'></p>'
clearRight: '<p class='clearRight'></p>'
clearBoth: '<p class='clearBoth'></p>'
```

#### Xdebug
Ikke alene kan man slippe for linier med 'errLog(get_defined_vars());' - man kan stoppe scriptafvikling og løbende beslutte at 'gå ind i' eller 'overspringe' med Xdebug. Dermed kan fejlfindings kapaciteten øges.  


EOMD,actors\tocNavigate($func)];