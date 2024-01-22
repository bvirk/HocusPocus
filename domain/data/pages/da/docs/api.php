<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
#### Demo uden API

[Fortunes uden api](/progs/html/fortunes) excellerer i lyrik ved at vise et nyt farvelagt visdoms ord for hver klik på en knap.  

EOMD,srclf('progs/Html.php','namespace'),<<<EOMD
$srcExpl
Class Html inkluderer muligheden for at udtrykke sig i jquery
</div>

prog/html/fortunes data fil layouter html'en

EOMD,srclf('data/progs/html/fortunes.md',1),<<<EOMD
Javascript udløser miraklet. Som tidligere vist laver PHP potentielt, når url er progs/html/fortunes, et html tag der inkluderer en fil med path:

EOMD,srclf('js/html/fortunes.js',1,'4','patch'),<<<EOMD

Man kan sige at den javascript genereret style og html indhold har data i sig.

#### Med API

Med API gøres data til noget der hentes over er request.  

Det er php delen af API anvendelsen der vises - altså servicen som svarer.  

Nyd lyrikken [fortunes API](/progs/fortunesAPI/fortune) eller i terminal

```
$ curl http://domain/progs/fortunesAPI/fortune && echo
```

EOMD,srclf('progs/FortunesAPI.php','namespace','11','patch a bug','7'),<<<EOMD
$srcExpl
Det er echo som er 'retur værdi' i API kald - og der anvendes json_encode af et array.
</div>

#### Fange fejl i PHP kildekode fra javascript

Værdsæt [fortunes API med php fejl](/?path=progs/fortunesAPI/fortune&mkErr) eller i terminal

```
$ curl "domain/?path=progs/fortunesAPI/fortune&mkErr" && echo

["<isPHPErr>","PHP ERROR in ...\/globalfuncs.php:26"]
```
PHP error is saved in config/filetoedit.txt. Med terminal i lokal webdir's document_root
```
$ cat config/filetoedit.txt

include(idontexists):_Failed_to_open_stream:_No_such_file_or_directory /var/www/vps/domain/progs/FortunesAPI.php:28
```
Indholdet af config/filetoedit.txt kan bruges til automatisk at åbne fejlbefængte i en editor på famøse linie. Et tool til dette er f.eks [wed](https://raw.githubusercontent.com/bvirk/localebin/main/wed)

#### PHP fejlrapporterings måde som kan tilgås læsbart fra javascript. 

EOMD,srclf('progs/FortunesAPI.php','__construct','2'),<<<EOMD


EOMD,srclf('globalfuncs.php','headerCTText','9'),<<<EOMD
$srcExpl
plain text i browser og global variabel \$usesJSON bliver sat til true.
</div>


EOMD,srclf('index.php','usesJSON'),<<<EOMD
$srcExpl
Vi er i index.php hvor requests bliver udført som kald af method på instantieret class. Exceptions ender i catch og fejlens meddelelse, filnavn og lininummer skrives til fil.
Requestet afslutter med echo af et json encoded array hvis første streng er et fastsat mønster for fejl.
</div>

Javascript som modtager fra API kald, håndtererer fejl svaret med kendskab til hvad IS_PHP_ERR er.  

Ikke alle PHP fejl returnerer til catch blokken - fatale fejl smider blot fejlmeddelelse som tekst response og afslutter yderligere script afvikling. javascript json parse fejl kan bruges i kildekoden som signal for, at det er sket.

EOMD,actors\tocNavigate($func)];