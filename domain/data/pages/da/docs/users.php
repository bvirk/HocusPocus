<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD

OS'er har proces identification med ejerskab. Enhver der requester en hvilket som helst webside er på en måde logged in - også på en statisk side uden cookies eller local storage.  
Man lægger normalt det autoriserede personrettet i begrebet logged in, men faktisk kan et vilkårligt request på nogle af de normale OS'er ikke ske uden at være som bruger med ejerskab.

På apache2 på en debian variant er her anno 2024 fundet at denne bruger hedder www-data.

Uanset hvor komplekst detaljegrad system man bygger ovenpå, så er det stadig  www-data som er ejer.  

Hvorfor ikke så lade www-data 'skifte hat' - når hans har autoriseret sig så bliver ejer www-data:hans og når det er grete, www-data:grete.  

Brugernavne er OS groups som ikke er OS users.

EOMD,srcf('defines.php','function OSGroups'),<<<EOMD

Grupper oprettes og tilføjes den user, apache web server processen har.

```
# addgroup newuser
# usermod -a -G newuser www-data

# systemctl restart apache2
```
Brugeres ejerskab til en datafil er simuleret ved at filens gruppe navn er bruger navn - og public kontra privat med read flaget for gruppe tilgang.  

Ved oprettelse af datafil sættes gruppen til logged in user.

EOMD,srclf('progs/NNNAPI.php','function newDFile',2,'chgrp\("data\/\$file"','^$'),<<<EOMD

Dialog menuen key 'c' toogler mellem privat og public - kan iagtages i statusline.

EOMD,srclf('progs/NNNAPI.php','function toogle','^$'),<<<EOMD

Brugere kan oprette password og efterfølgende logge ind - i en PHP registrering som __ikke__ har noget med OS level passwords at gøre.  

Passwords kan kun ændres ved, med fil adgang, at slette password for en bruger.  

Variabel \$_SESSION afspejler om der er en loggedin user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn',3),<<<EOMD
I dialog menuens html er et link der skifter mellem login og logout.

EOMD,srclf('actors/StdMenu.php','<\?=\$ahref',1,'thisUrl',4),<<<EOMD
c
EOMD,srcf('progs/LoginRecieve.php','windowOldLocation',3,'function logout',3),<<<EOMD
$srcExpl
Efter at have fjernet bruger fra \$_SESSION genåbnes siden gennem javascript.
</div>

Som en tilbagemelding åbnes dialog menuen tilvejebragt af et cookie baseret flag.

EOMD,srcf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu',2)
    ,srcf('js/PageAware/StdMenu.php','function\(\)',4),<<<EOMD
$srcExpl
Det er ready funktionen som jquery giver - køres når siden er loadet
</div>

### Login formen

Html form elementet muliggør signin og signup. Det er samme form med en button til at skifte mellem de to ting. 

EOMD,srclf('data/progs/html/login.php',1),<<<EOMD
$srcExpl

Variabler tildeles så formen bliver signin eller signup - som udgangspunkt signin medmindre encryption filen 'er tom'. 
\$_GET['url'] genpostes for at kunne åbne samme side hvorfra login/logout/registrer blev aktiveret.  
</div>

EOMD,srclf('progs/LoginRecieve.php','function saveEncryption',14),<<<EOMD
$srcExpl

Bruger, krypteret password og salt der indgår i kryptering gemmes i php AUTHFILE som array, __hvis__ bruger finde i constant array USERS, og ikke allerede findes i AUTHFILE.
</div>

EOMD,srclf('progs/LoginRecieve.php','function oneauth',11),<<<EOMD
$srcExpl
\$_SESSION[LOGGEDIN] sættes til bruger listet i USERS som logger ind med password som passer med det i AUTFILE, ellers sættes \$_SESSION[LOGGEDIN] til den tomme streng.
</div>

#### AUTHFILE
I AUTHFILE er brugere key til par af encryptet password og salt - alt i et array. Det har syntaksen på et PHP array så det kan indlæses med include.

_config/encrypted.php_
```
<?php
// Deleting all password by delete from line 4, but keep last line. NO TRAILING EMPTY LINES 
return [
'final' => ['65nlYh2WUQ6zQ','6599e9df16cb4']
,'bob'=>['65IYvsRzipQ2U','659abd9c9e545']
];
```
### Automatisk login
Alt ovenstående er blot for, f.eks, at udføre
```
\$_SESSION[LOGGEDIN]=USERS[n]; // 0 ≦ n < antal brugere
```
Authentication er begrænsning af adgangsvejen til at tildele til \$_SESSION[LOGGEDIN].   

Authentication er relevant ved online adgang. For at kunne slette, ændre og editere skal man være loggedin og datafiler oprettes med loggedin bruger som flaget ejer.   

Hvis HocusPocus bruges med adgang til webdir kan det laves sådan at der automatisk 'loggges ind' på en konto.

EOMD,srclf('globalfuncs.php',"array_key_exists\(LOGGEDIN",7),actors\tocNavigate($func)];
