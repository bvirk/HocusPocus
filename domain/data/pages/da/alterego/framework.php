<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Starten var uden anvendelse af classes, struktureret omkring en liste af sider. Der blev anvendt en del 'use function' deklarationer. Noget upload og image skalering. jeg lærte hvor mange måder man kan overføre parametre på i PHP.

Ny start med mod\_rewrite og instantiering af class i  den index.php som modtager alle requests.
Classes havde alle namespace 'pages' og lå dermed i directory pages. Url's path havde 2 elementer - class/method.  

Det kaldte på en base class for at undgå repeterring - class PageAware blev født.  

Hvor det, selv med en base class, stadig var for meget med alle de methods, kom magiske \_\_call(\$func,\$parms) til hjælp.  
Der skulle blot opfindes en fleksibel systematik til at hente data til de 'virtuelle methods' som blev fanget i PageAware's method \_\_call().  

For hver pages class var der et directory i pages stavet på samme måde som requestets class i hvilket der fandtes en fil med datainhold for body elementet til den pågældende side.  

Datafilerne extension var .md eller .php - .md fordi de indeholdt markdown tekst. De kunne skrives som en liste af HEREDOCs -  men de blev inkluderet i \_\_call(), så det var PHP filer og det var en liste af strenge der blev returneret fra datafilen. Når de også kunne være med extension .php er det fordi de også kunne være PHP tunge - dels før det afsluttende return og med funktionskald indskudt mellem HEREDOCs afsnittene. 

css og javascript filer var tilknyttet specifikt til en side, en class eller var altid med - der blev dannet tags til deres inkludering afhængigt at deres eksistens. Ingen konfigurering hvor den i forvejen fandtes i filsystemet i og med at css og javascript ligger i directories der afspejler relation til henholdsvis alt, en pages class eller en side.

Hvis man kalder systemet beskrevet herover for version 1, så er version 2 med ubegrænset url path dybde.

Nu er url path simpelt hen namespace og directory for instantieret class.

Det er lavet sådan, at det findes et arve hierarki af det man har brug for til at site. Det lå dengang også i pages.

En class som instantieres fra url path har en class fra class hierarkiet som base, mem ingen har den som base. Man sige PHP namespace systemet indekserer ind i et mindre antal muligheder.      

css og javascript følger nu begge paradigmer. Filerne ligger i directories så de inkluderes som følge af både sammenfald med url og hierarki. Det er faktisk lidt indviklet at rode med manuelt.  
Ikonet [☕](/?path=progs/html/extern&refer=$classPath/$func) som er øverst til venstre på alle sider, linke til oplistning af eksterne filer - eksisterende er blå, potentielle sorte.

Datafiler ligger ikke længere i pages men i directory data - men directory struktur pages er identisk med data/pages - den første indeholder PHP classes - den sidste datafiler med extension .md eller .php

PHP Menuen droppes. Der laves en sitemap class.

Method \_\_call(\$func,\$parms) flytter til abstract class \\HocusPocus hvorfra PageAware arver.  
På den måde kan man hente data i classes uden de behøver at være pages - og det bliver tilfældet for directory progs som er til API'er. 

Class PageAware skrumper til kun at lave den del af html document som ikke er body element indholdet, og den gøres abstract.
Class StdMenu, som viser dette, arver for PageAware og implementer pålagte function stdContent() som krævet af HocusPocus. 

Class hierarkiet har fået namespace actors -  bortset fra HocusPocus som ligger i Document Root - det er fordi dens namespace løshed bliver brugt som stopklods til dannelse af en hierarki path som så starter med PageAware.  

Hierarki path bruges uniformt med url path til betinget dannelse af tags for inkludering af eksisterende css og javascript som er beliggende i matchene directories.

Filemanager nnn har været inspirationskilde til den nye javascript dialog menu. Første version, som var en stor javascript fil, kaldte på de nye måder med javascript moduler.  

Derfor blev javascript tags dannelsen ændret - der hvor der ikke blev fundet fil med extension .js blev der søgt efter en fil med extension .php som så blev inkluderet.

Dialog menuen er baseret på Javascript, Ajax og API'er i directory progs som returner JSON formateret.

Næste skridt er at extende dialog menuens navigering sådan at højre pil på en datafil skifter listningen til at vise aktuelle og postentielle externe referencer til css og javascript filer - hver sin farve for aktuel kontra potentiel. Man kan åbne for editering eller 'slette' en aktuel (gøre potentiel.) Status linien kunne vise hvor mange sider der anvendte markerede css eller javascript fil. 

EOMD,actors\tocNavigate($func)];