<?php
$domain=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
HocusPocus har rollen at hente data. Den er base class for alle classes som henter indhold fra data directory  


I method defCall(\$func), som kaldes i fravær af en 'egentlig method', hentes data. Det sker i den class som svarer til url'en og som nedaver fra HocusPocus.  

EOMD,srclf('index.php','try',7),<<<EOMD

### Rendering

EOMD,srclf('HocusPocus.php'
    ,'@param array which last',3,
    'Replaces pattern in last array element',3,
    'abstract class',4,
    'function defCall',1,'include\(\$incPath',24),<<< EOMD
$srcExpl
Det som 'data filen' \$incPath returner er et array af strenge - \$content. Det __kan__ være en enkelt streng som så bliver array gjort for  uniform loopning.  
Der jongleres med to stakke, content stack, \$cStack og tempate stack, \$tStack  

</div>

EOMD,srclf('HocusPocus.php','->stdContent',1,'abstract function',1),<<< EOMD
$srcExpl
HocusPocus kan ikke selvstændig instantierers.  
Fordi stdContent() er abstract er det dens implementering i en subclass som anvender property \$body  
</div>

### Variabler til indsættelse i indhold
Den simpleste måde at gøre ting stylebart på er at have variabler til indsættes i heredocs. 

EOMD,srclf('HocusPocus.php','function defCall',1,'datafileExists',5,'function enheritPathElements',12),<<< EOMD
$srcExpl

Funktion enheritPathElements returner class hierarki arv som array af path elementer. Det er classes med namespace actors som indgår.  
Data filen \$incPath kildekode miljø er et mix af dels at være i samme variabel scope som defCall og dels at kunne returnere indhold til defCall. Variabler deklareret i \$dataVarsFile, som inkludes før \$incPath bliver en del defCall's variabel scope. 
</div>

### Ikke eksisterende url
Vi har set at index.php håndterer hvor vidt en urls class eksisterer, men der garanteres ikke at sidste path element, som udpeget data, eksisterer.

EOMD,srclf('HocusPocus.php','"data\/\$classPath\/\$func"',3,'neither',9,'function noDataAvail',6),<<< EOMD
$srcExpl

dataFileExists(\$incPath) returnerer true hvis tilføjning af enten .md eller .php til reference parameter \$incPath bliver navnet på en eksisterende fil.  
Hvis filen med data ikke findes, sker der en differentiering mellem om det er en pages (DEFCONTENT) eller progs url. progs udløser altid en exception (programmørfejl), mens der for pages vedkommende også i viste kilde udløses en exception - men der kan vælges ved  udkommentering mellem en exception eller kald af default page.<br>  
Konteksten for nødvendighed af brug af javascript til redirection er at pages (DEFCONTENT) alle arver fra actors\\PageAware som arver fra HocusPocus. Det betyder at alt html incl &lt;body&gt; target er outputtet og requestet afslutter med function __destruct() som outputter  &lt;/body&gt;&lt;/html&gt;
</div>

### Content type text/plain
```
...HocusPocus/domain$ echo hello >hello.php
curl -k -i  $domain/hello.php
HTTP/1.1 200 OK
Date: Thu, 07 Mar 2024 10:04:23 GMT
Server: Apache/2.4.58 (Ubuntu)
Content-Length: 6
Content-Type: text/html; charset=UTF-8
```
Apache sender Content-Type: text/html for extension .php hvis ikke man indleder med en anden content-type  

når text/plain er valgt i \_\_constructer() drejer sig om bekvemt syn i browser for småtest og API'er.  
Det overrides ( ved fravær ) natuligvis for alle pages og de progs som måtte have brug for det.  

API'er kan også bruger datafils måden (nedarve fra HocusPocus) - det gør de som regel ikke - de har methods.  

Det er nice bare kunne se API output i browser men content-type anvendes ikke i javascript httprequest brug.  
EOMD,actors\tocNavigate($func)];