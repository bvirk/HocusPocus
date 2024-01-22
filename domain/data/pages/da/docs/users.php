<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
Brugerbegrebet er rudimentært med en hardcoded list. Brugere kan oprette password og efterfølgende logge ind. Passwords kan kun ændres ved, med fil adgang, at slette password for en bruger. En session cookie registrerer logged ind bruger. Der anvendes ikke permanente cookies.

EOMD,srcf('defines.php','USERS','1'),<<<EOMD


Variabel \$_SESSION afspejler om der er en loggedin user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn','3'),<<<EOMD
I dialog menuens html er et link der skifter mellem login og logout.

EOMD,srclf('actors/StdMenu.php','<\?=\$ahref','1','thisUrl','4'),<<<EOMD
c
EOMD,srcf('progs/LoginRecieve.php','windowOldLocation','3','function logout','3'),<<<EOMD
$srcExpl
Efter at have fjernet bruger fra \$_SESSION genåbnes siden gennem javascript.
</div>

Som en tilbagemelding åbnes dialog menuen tilvejebragt af et cookie baseret flag.

EOMD,srcf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu','2')
    ,srcf('js/PageAware/StdMenu.php','function\(\)','4'),<<<EOMD
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

EOMD,srclf('progs/LoginRecieve.php','function saveEncryption','14'),<<<EOMD
$srcExpl

Bruger, krypteret password og salt der indgår i kryptering gemmes i php AUTHFILE som array, __hvis__ bruger finde i constant array USERS, og ikke allerede findes i AUTHFILE.
</div>

EOMD,srclf('progs/LoginRecieve.php','function oneauth','11'),<<<EOMD
$srcExpl
\$_SESSION['loggedin'] sættes til bruger listet i USERS som logger ind med password som passer med det i AUTFILE, ellers sættes \$_SESSION['loggedin'] til den tomme streng.
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
\$_SESSION['loggedin']=USERS[0];
```
Authentication er begrænsning af adgangsvejen til at tildele til \$_SESSION['loggedin'].   

Authentication er relevant ved online adgang. For at kunne oprette, slette, ændre og editere skal man være loggedin.  

Hvis HocusPocus bruges med adgang til webdir er det lidt et show - selvom det er gjort let.  

Derfor logges automatisk ind hvis der ikke er andre der er loggedin __og__ der foreligger en indikering af at have filsystem adgang til webdir - på browsende computer eller LAN.
EOMD,srcf('globalfuncs.php','automatically logged','3'),<<<EOMD
Link teksten i dialog menuen viser ikke 'logout' foran USERS[0] - man stadig klikke på den og blive logget ud af USERS[0].
EOMD,srclf('actors/StdMenu.php','isLoggedIn','3'),srcf('defines.php','USERS','1'),actors\tocNavigate($func)];