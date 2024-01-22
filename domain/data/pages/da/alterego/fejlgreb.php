<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Fejlgreb betyder løsningsmåder som senere viser sig at være forkerte.  
Beskrevet her fordi det ville gøre flowet i forgående afsnit for svært at følge.  
Fejlgreb er sjove fordi de er en slags 'den havde jeg ikke set komme'.  

##### Querystrings måden 
Apache er konfiguret med en RewriteRule som laver url path om til query string parameter med navnet path. 

Oprindeligt var der to RewriteRules der muliggjorde at overføre parametre idet sidste path element kunne indeholde tegn så det blev opfattet som parametre.  
Det var smart og snedigt, men krævede lag af encoding/decoding.  

Hen ad vejen viste der sig problemer med enkeltheden i relative links og tegnbrugen viste sig at stride mod [RFC](https://en.wikipedia.org/wiki/Request_for_Comments) standarderne.  

Jeg måtte konkludere at jeg var gået for langt med at alle url'er kun skulle være med path.  

Det er nice i browserens adresselinie og historik, at kunne se og genvende url'er som dr.dk/nyheder og dr.dk/lyd/oversigt, men skal man overføre parametre i et GET request, så er løsningen querystrings måden.

##### Hierarki

Overgang til ubegrænset path dybde betød at der fandtes en class til hver eneste url path element - bortset fra sidste som repræsenterer en method.  
Det blev først overvejet om det hele skulle være et arve hierarki - at enhver class hvis namespace var forlængelse af en anden class's skulle arve fra den.  

Hvis det skulle gælde ufravigeligt ville enhver url repræsentere den samme base 'hele vejen op'. Det dur ikke da der netop skal kunne vælges andre layouts 'nede i forgreninger'. 

Man kunne lave med den undtagelse at class kunne bryde med at arve fra den class hvis namespace var det samme uden sidste led. Men man ville være nød til at forholde sig til url path separat, og dermed ville det blot blive en kompleksitet. 

Derfor blev løsningen at url path var et index ind et andet arvehierarki, et arvehierarki fra namespace actors  

Enhver url path afstedkommer instantiering af class som arver fra en actors class og intet arver fra den.

EOMD,actors\tocNavigate($func)];