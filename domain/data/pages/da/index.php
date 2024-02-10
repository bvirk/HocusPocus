<?php 
use utilclasses\Sitemap;
$sitemap = (new Sitemap())->dirlisthtml();
return [
"<!<div class='auto80'><div class='centertext'>#html#</div><div class='marginleft170px'>#html#</div></div>"
,
    <<<EOMD
# HocusPocus
### en php-nnn applaus

Navigering med tastaturet  

|               |                                       |
|:--            |:--                                    |
|F9             |menu                                   |
|c              |skift mellem synlig og skjult          |
|e              |rediger fil                            |
|m              |ændre tilladelser                      |
|n              |ny fil eller dir                       |
|o              |skift ejerskab                         |
|r              |omdøb fil eller dir                    |
|q              |afslut menu                            |
|t              |tøm mappen trash                       |
|x              |flyt fil eller dir til mappen trash    |
|y              |confirm flyt til mappen trash          |
|z              |reetabler alt fra mappen trash         |
|pile taster    |naviger rundt                          |
|Esc            |afslut eller fortryd                   |
|Enter          |vælg side                              |
|Home           |standard side                          |

![keyboard]($imgPath/keyboard.jpg)
EOMD,">!>", <<<EOMD
#### Om

HocusPocus er et lille PHP web framework med et Javascript menusystem det er inspireret af [filemanager nnn](https://github.com/jarun/nnn/wiki).

Menu systemet understøtter oprettelse, omdøbning og sletning af sider og deres directories.  

Css og javascript er forbundet med sider efter specialiseringsprincipper kendt for klassehierarkier.

Dialog menuen understøtter oprettelse, omdøbning og sletning af sider og deres mapper og redigering af indhold i browseren.

HocusPocus' modstykke til nnns 'e' for redigering valgt, er at gemme filnavnet i en fil på serveren, __og__, valgbart, åbne filen til redigering i en ny browserfane. Dette, to vejs valg, understøter en enkel måde til mindre rettelser i browser og en mere assisteret måde i en rigtig editor. Hvordan lokal redigering foretages afhænger af, hvordan serverens filsystem gøres tilgængeligt.
#### Sitemap

$sitemap
EOMD];