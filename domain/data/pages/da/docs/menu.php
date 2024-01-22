<?php
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
HocusPocus har haft mange mindre magiske forgængere og er formet af ideer som pludselig har kuldkastet ældre måder.  

Det lå heller ikke klart hvad dette lille php framework skulle bruges til - var det ikke nærmere et dokument håndteringssystem baseret på markdown dokumenter.  

Ideer florerer på nettet - også for Linux brugere. Filemanager [nnn](https://github.com/jarun/nnn/wiki) afløste traditionelt anvendte [Midnight Commander](https://en.wikipedia.org/wiki/Midnight_Commander)

Menuen er den modale dialog der popper op, når hamburgeren' i øverste højre hjørne, aktiveres.   

Man kan oprette, slette, omdøbe og redigere filer og mapper - menuen gør HokusPocus til et CMS.  

Menuen fremtræder mere som en administrations ting end noget man finder vej med på en webside. Man kan så betragte dens basis som noget der genbruges i design af en anden menu.

Teknikken er javascript og [AJAX](https://en.wikipedia.org/wiki/Ajax_(programming)#References) og så meget wannabe nnn funktionalitet der løser opgaven.  

Tabs og makering findes ikke - vil man flytte en fil må man oprette en ny, flytte indhold og slette oprindelige.  
Visse ting kan den, som nnn ikke kan; den kan synkronisere omdøbning af directories med de nødvendige ændringer i HocusPocus namespaces for classes.  

Næste kapitel er om den class der implementerer dialog menuens html skelet og henter javascript. 

EOMD,actors\tocNavigate($func)];