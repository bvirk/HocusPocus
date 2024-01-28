<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
Formålet med dette lille framework at holde styr på css og javascript filer. Det er kategoriseringen af enkelte siders afhængigheder af delmængder af css og javascript skal understøttes systemisk.

Flere mekanismer er i spil
1. property arrays \$jsFiles og \$cssFiles
2. url'en
3. class hierarkiet

punkt 1

- Tags der inkluderer angivne filer eller CDN referencer laves. 


For punkt 2 og 3

- Der laves tags til at at hente foreningsmængden af de filer som findes og matcher
- Kaffekop ikon øvest til venstre på StdMenu sider viser mulige og aktuelle filer 


### method getExterns() i actors\PageAware

##### Externe libraries
Externe libraries er ting man ikke selv udvikler på - sådan noget som jquery og google fonte.  

property \$cssFiles og \$jsFiles kan være lokale filer eller CDN links. Fil links starter med  /css/ eller /js/ for henholdsvis stylesheets og javascript.

EOMD,srclf('actors/PageAware.php','jsFiles = \[\]',2,'function getExterns',1,'cssFiles as',4),<<<EOMD
$srcExpl
Det ser pænest ud at \$cssFiles og \$jsFiles er tomme her, for indhold er tiltænkt classes som der ikke arves yderligere på.
</div>

##### Class hierarki indekserede css og javascript filer
Det som man opnår ved at specialisere i class definitioner opnås også på anden vis, men stadig følgende class hierakiet. 

js og css filer er placeret i sammme directory struktur som class hierarkiet - stadig under css/ og js/.  

Da alle html documents arver fra actors\\PageAware bliver følgende, hvis de eksisterer, common stuff
- css/PageAware.css
- js/PageAware.js eller js/PageAware.php

Hvis der i hierarkiet ikke findes en fil med extension .js, kigges der efter en matchende navngivet med extension .php
EOMD,srclf('HocusPocus.php','function enheritPathElements',12),<<<EOMD
$srcExpl

Når class_parents(\$this) er reversed om, kommer HocusPocus først.

(vær opmærksom på, at det er en pages class, der arver fra en actors class, der arver fra actors\PageAware, der er \$this)

Foreach-løkken opbygger en path som path elementer i et array. Det er class navne fratages deres namespace der bruges. 

Fordi HocusPocus ikke har noget namespace, blev det ikke en del af path. Fordi det er parents vi beskæftiger os med, er den  instansierede pages class ikke i blandt.

Class hierarki path er næsten \$pe's modstykke, derfor \$e_pe for 'enherittance_pe'
</div>

##### Url indekserede css og javascript filer

Disse er i to grupper
1. alle der kan repræsentere flere sider.
2. de der kun gælder for en specifik side.

Vedrørende en url med n path elements  
```
\$pe[0]/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1]  
```
$srcExpl
'pages', \$pe[0] indgår ikke i indekseringen vedrørende css og javascript
</div>

##### gruppe 1  

Fællesmængden af måske eksisterende filer
```
css/\$pe[1].css  
css/\$pe[1]/\$pe[2].css  
css/\$pe[1]/\$pe[2]/\$pe[3].css  
...
css/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2].css  

js/\$pe[1].js eller .php  
js/\$pe[1]/\$pe[2].css eller php 
js/\$pe[1]/\$pe[2]/\$pe[3].css eller php 
...
js/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2].css eller php  
```
$srcExpl

I loop fra n=1 til n-2 er som at hente til put bagpå streng fra array_slice(\$pe,1,-1)
</div>

##### gruppe 2
```
css/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1].css
js/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1].js eller php
```

##### uniform processering af hierarki og url


EOMD,srclf(
    'actors/PageAware.php'
    ,'function getExterns',5
    ,"'src','js'",1
    ,'function incFiles',12)
        ,<<<EOMD
$srcExpl
I inderste forEach kaldes extRef(...) med den løbende directory streng forlængelse som gælder for hvad der herover er kaldet gruppe 1 og efter den forEach gruppe 2. Parametre til extRef er hvad der skal til at lave html tags og attributter.
EOMD,'>!>',<<<EOMD

EOMD,srclf('actors/PageAware.php','function extRef',7),<<<EOMD
$srcExpl
I extRef undersøges der om en ikke eksisterende .js fil i stedet er en .php fil, som så includeres. lastmRef tilføjer ?lastm= (unixtime) til src eller href attributtens værdi.
</div>

EOMD,srclf('actors/Pagefuncs.php','function lastmRef',3),<<<EOMD

Vi har nu set at HocusPocus tager sig af at hente data og actors\\PageAware bruger de data til at lave et html document med alt dens gemüse af tags til at hente css og js filer.  

At specialisere det at lave html dokumenter muliggør kun at hente data hvor der ikke er brug for html - som i API'er der returnerer json. PageAware starter forgreningen på specialisering til html.

Det er ikke meningen at man skal bruge PageAware direkte, for så låser man sig ude for at gøre noget andet end det man specialiserer PageAware til.  

Man arver, som i den StdMenu der layouter disse ord. Før kapitlet om StdMenu, om dialog menuen 

EOMD,actors\tocNavigate($func)];