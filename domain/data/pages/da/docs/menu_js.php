<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func,1),
    <<<EOMD
Dialog menuen har onClick events så der kan navigeres med et pointing device, men fil håndtering er kun muligt med tastatur.

### Modulerne
Dialog menuen tilhører  class StdMenu. Det betyder at følgende hentes:
EOMD,srclf('js/PageAware/StdMenu.php','Nasty','1','jsmodules\/StdMenu\/main\.js','1'),<<<EOMD
$srcExpl
main.js ligger i et directory som har sammen navn som den class den tilhører.  
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',1),<<<EOMD
$srcExpl

request.js har path ../jslib mens de andre filer ligger i sammen directory som main.js  
Alt importeret i main.js bruges til at hæfte funktioner på object allFuncs som dermed kan kaldes da de er tildelt html attributters onClick event.
</div>

Skillelinien mellem om en javascript fil ligger i samme directory som main.js eller i jslib, er hvorvidt det indeholder kontekst fra den aktuelle anvendelse eller er fuldt parameteriseret.

- formsubmit
    - fælles request afsendelse for commands med prompt for fil eller dir navn.
- hamMenu
    - tegner indhold i dialog menuen.
- keyboard
    - fanger keyboard events og eksponerer skift af keyboard event function.
- main
    - hæfter onClick event til functions.
- request
    - to request functions, en for GET og en for POST.
- reqCallBacks
    - fem functions der modtager response.

### Requestet
Et request fanges af API, som er implementeret i PHP, og response modtages af en javascript function.  
EOMD,srclf('jsmodules/jslib/request.js','let  httpRequest','11'),<<<EOMD
$srcExpl
Request er formidlet af XMLHttpRequest objektet - property onreadystatechange tildeles den function som skal modtage response på request.  
</div>

For at få et single point of source bruges en constant overalt som første argument til request(...) 
EOMD,srclf('jsmodules/StdMenu/hamMenu.js','const APIName','1'),<<<EOMD
$srcExpl
Af det følger at argument streng, som er '&' adskilt liste af 'key=value' par, skal indldes med '&'
</div>


### Åbning af dialog menuen
Hamburger ikonets onClick attribut har en function 
EOMD,srclf('jsmodules/StdMenu/main.js','hamDrawMenu = hamDrawMenu','1'),<<<EOMD
Den kan også åbnes med F9
EOMD,srclf('jsmodules/StdMenu/keyboard.js','function whenNoMenu','7')
    ,srclf('jsmodules/StdMenu/hamMenu.js','let isFirstDraw','1','function hamDrawMenu','9','function hideInput','3'),<<<EOMD
$srcExpl

Med setCurkeyhandler skiftes til keyboard handler navigate(event).  

Global variable curDirStr bruges når der navigeres op/ned i directories.  
Javascript location.pathname er med '/' forest, curDirStr er uden. Grundet redirection af det nøgne domæne optræder '/' alene faktisk ikke. (med mindre nogen ødelægger redirection)  

Sidste led i url'ens path er datafilen - det er det directory hvori den ligger som skal vises - derfor fjernes sidste led i curDirStr.  

Menuens synliggørelse med property block for display

hideInput skjuler prompten og dermed dens mulighed for, vha. return, at sende POST request.  

Resten af tegning af dialog menuen sker i showMenu() med resultatet af hvad API kaldet til method ls returnerer.  

showMenu() kaldes løbende for at gentegne, men kun her med flaget isFirstDraw=true for at sætte markøren på den datafil der tegnede siden hvori dialog menuen blev åbnet. 
</div>

Response af [ls](nnnapi/ls), som returnerer et array af arrays af egenskaber for hver fil, modtages af showMenu

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function showMenu','27','function catchResp','13'),<<<EOMD
$srcExpl

Enhver response function skal indledes 'if (httpRequest.readyState ....) return;' - ellers spiller det ikke.  

Derimod er hentning i try catch, med differentiering mellem json parseable og signaleret php error det samme for alle fem  responce functioner, så det er uddelegeret til function catchResp.  

En knap med id: navBack gøres synlig når curDirStr er længere en 'pages' ('pages' er top directory)  

showMenu() kaldes hver gang dirlisten skal opdateres, så &lt;ul&gt; med id: wdFiles tømmes indledningsvis.  

I løkken opbygges fil listen som links i &lt;li&gt; tags.  
curDir er et array af arrays af fil egenskaber modtaget fra API kald 'ls'. Ud fra at curDir[index][1] er '/' for directories og '' for filer tildeles variabler look, href og clknav for henholdvis filens udseende som link, dens href attribut og dens evt. mappe knap. Hvert a element for også et id benævt pid efterfult at index.  
curDirStr er også id for et &lt;div&gt; som så også vises.
</div>

showMenu afsluttes med kald til initDomElements.
EOMD,srclf('jsmodules/StdMenu/hamMenu.js','function initDomElements','14'),<<<EOMD
$srcExpl

lid indeholder det array af DOM elementer der bruges til at udvælge en fil.

cid, for current id, er indeks i lid - altså markøren som heltal. cid sættes til 0 eller, hvis isFirstDraw=true, indeks til den fil som er datafil til siden hvor dialog menuen blev åbnet.  
'const index in curDir' er strenge, derfor det lille '+' for at tildele heltal til cid.  

statusline(...) viser beskrivelse af valgte fil, som det kendes fra filemananger nnn.  

lidInverse() fremhæver hvilken fil der er valgt ved at ombytte farver for tegn og baggrund.   
</div>

###### fremtidige emner i dette kapitet
- statusline
- navigering
- andre taster i keyboard
- prompting for txtinput
- POST, submit form og savefile
- hvordan med flere bogstaver - måske redesign med endnu en event function
- reqcallbacks som ikke ellers er dækket

EOMD,actors\tocNavigate($func)];