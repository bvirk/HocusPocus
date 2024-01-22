<?php
use function actors\srcf;
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
### Method kontra data fil
Følgende fungerer i et installeret HocusPocus system. Pointet er ikke at  link eksemplerne virker, men hvorfor de virker.

EOMD,srcf('progs/Play.php',2),<<<EOMD

_Eksempel med method_ [/progs/play/myMethod](/progs/play/myMethod)

Url med rewrite understøtter ikke parameter overførsel - hvis man vil det må man ty til traditionel query string

_Eksempel med method og query string_ [/?path=progs/play/myMethod&name=kurt](/?path=progs/play/myMethod&name=kurt)


EOMD,srcf('data/progs/play/index.md',1),<<<EOMD

_Eksempel med data fil_ [/progs/play/index](/progs/play/index)

_Eksempel med method og query string_ [/?path=progs/play/index&name=kurt](/?path=progs/play/index&name=kurt)


### Et mere komplekst eksempel
Her er nogle finurligheder for at demonstrere

EOMD,srclf('data/progs/play/demo.md',1),<<<EOMD

_Plain tekst Eksempel_ [/progs/play/demo](/progs/play/demo)  
_Html Eksempel_ [/progs/html/demo](/progs/html/demo)


##### progs\\Play er ikke et html document
progs\\Play arver alene fra HocusPocus - der bliver ikke dannet html head og andet gemüse og for at det skal kunne gøre sig i browser er header med Content-type: text/plain afsendt.  
##### Måder at skriver på hvad der returneres 
Det er et array of strings der returneres.
PHP heredocs afsnit er mest skrivemåden, men formålet med at returnere et array af strenge giver forskellige udtryks muligheder.  
At bruge functioner der returnerer en streng er brugen af srclf() et eksempel på. Den bruges til at retunere __s__ ou __r__ __c__ e med __l__ inienummer og indledende __f__ ilnavn. Det ses at det er selvsamme fil der er objektet og strengen som returneres underkastes markdown konvertering.

##### Definere ting før returnerende array 
Heredocs understøtter interpolation af variabler og array values indekseret med tal.  Derfor kan det være bekvemt at oprette variabler før return statement. Indholdsmæssigt ment dollar skal have backslash foran i heredocs   
Man kan også oprette funktioner før return - det bruges her til at se \$pe arrayet.  
Det som vises i data/progs/play/demo.md er variabler der er adgang til fordi de er defineret i method HocusPocus->\_\_call.
##### Template
Bemærk &lt;div class='top'&gt; og &lt;div class='bottom'&gt;   
For at kunne style individuelle html snippets fra markdown konverteringen kan de indkapsles i andet html. Templates er array elementer som starter med '<!<' og indeholder en eller flere ![html]($imgPath/html.jpg "må ikke forekomme som streng i indhold") strenge.  
Det er et kendetegn at man ikke skal holde styr med antallet af array elementer - og derfor anvendes afslutnings elementer der markerer afslutningen på en liste som skal erstatte #html# strengen i templaten. Afslutningsstrengen er '>!>' og et element som slutter med dette markerer afslutningen på en liste. 
```
return [ "<!<div class='all'><div class='afsnit'>#ht?ml#"</div><div class='slut'>#ht?ml#</div></div>"
, <<<EOTD
afsnit1
EOTD, <<<EOTD
afsnit2
>!>
EOTD, <<<EOTD
afslutning
EOTD];
```
$srcExpl
Fordi &gt;!&gt; skal være slut på strengen er EOTD,&lt;&lt;&lt;EOTD på linien under nødvendig. Man kunne også skrive det i en linie som EOTD,"&gt;!&gt;",&lt;&lt;&lt;EOTD. At afnit 1 og 2 er gjort til 2 elementer er vist her for at understrege at elementer samles på en liste.<br>Strengen '#ht?ml#' i eksemplet herover skal læses som den kun må skrives i templates, som værende uden '?' mellem t  og m.
</div>
EOMD,<<<EOMD
I nogle situationer er det for besværligt med template og termination. Man kan også skrive følgende som virker uden det gennemgå rendering. Html er legalt  markdown.
```
...
<div class='ting_som_styles'>  
Mit afsnit
</div>
...
```
Da det ofter er sammen class attribut der anvendes, er der en mekanisme for at tildele variabler.
EOMD,srcf($dataVarsFile,1),<<<EOMD

```
..
\$srcExpl  
Mit afsnit
</div>
..
```
$srcExpl
Sådan fik dette grønne skriv en solid grøn dobbelt linieret left border 
</div>

EOMD,srcf('css/PageAware/StdMenu.css','code explaining','10'),<<<EOMD

Hvis indholdet i &lt;div&gt; ønskes markdown konverteret, kan man lave en tom linie efter \$srcExpl eller følgende som renderes.

```
...
EOTD,"<!".\$srcExpl.'#ht?ml#</div>',<<<EOTD
Mit afsnit
>!>
EOTD,<<<EOTD
...
```
$srcExpl
Igen, læs uden '?' mellem t og m i #ht?ml#
</div>

Det er ikke nødvendigt at liste afslutte til sidst i datafilen.


Det var om data måden som i praksis er default, mens implementeret methods er undtagelsen - lige det modsatte af definitionsmæssigt i php's virkemåde.  

EOMD,actors\tocNavigate($func)];