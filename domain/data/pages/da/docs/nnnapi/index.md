<?php
return ["<!<div class='auto80'>#html#</div>"
,
    <<<EOMD
## NNNAPI
[nnn](https://github.com/jarun/nnn/wiki) er en tekst baseret linux filemanger som betjenes med tastatur og har nogle intuative taster for almindelige filoperationer.  
En af dens karakteristika er at den er menuløs og dermed let, GUI mæssigt, at efterligne som dialog menu i browser.  

Dialog menuen er javascript baseret og serviceres af NNNAPI i php.  

Det er data/pages directory tree som dialog menuen kan panorere rundt i, men fil operationer er komplekse og involverer og også css/, js/, pages/ og img/pages. Fil operationer som opret, omdøb og slet kan omfatte flere filer og/eller deres indhold - ting som ville være træls og let at gøre forkert manuelt, sikres dermed at blive gjort konsistent. 

At returnere bruges i det følgende om det, som i PHP API kildekode læses som echo - for det er, set fra den javascript function som håndterer response, en returværdi fra API kald.

API methods returnerer hvad der passer til den javascript function som modtager response. Det er et argument til kaldet af request funktionen, hvilke function som skal modtage response. Det er givet, for en bestemt API method, hvilken javascript function der modtager response fra netop den API method.

En streng eller et json encoded array af strenge er et almindeligt response, hvor første element i arrayet har signal værdi af om command lykkedes eller ej. Det værdien IS_PHP_ERR der agerer flag. Det udnyttes i javascript kildekoden at array indeks og streng indeks skrives på samme måde, til at konkludere bredt på indeks 0 af response.


Generelle keys i \$_GET argumentet til API methods
- 'selname'
    - betegner filen der er 'selected' i dialog menuens liste
- 'txtinput' 
    - svaret, som prompten, i en command i dialog menuen, modtager.
- 'curdir'
    - current directory for dialog menuens dirliste - den starter med pages/ og adresserer dermed fra data/ i webdir og er samtidig path i webdir for pages class.

Om variabel navne
- Postfix WOE i variabel navn for 'without extension'.

url encoding
- '|' er en encoding af '.' i url.



### TOC
- [edit](edit)
- [emptyTrash](emptyTrash)
- [ls](ls)
- [mkDir](mkDir)
- [mv](mv)
- [mvDir](mvDir)
- [newFile](newFile)
- [rm](rm)
- [rmDir](rmDir)
- [saveFile](saveFile)
- [setSessionVar](setSessionVar)
- [undoTrash](undoTrash)


EOMD,actors\tocNavigate('index')];