<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD

OS'er har proces identification med ejerskab. Enhver der requester en hvilket som helst webside er på en måde logged ind.
Et vilkårligt request på nogle af de normale OS'er sker som en grundlæggende user med ejerskab til filer - den user webserver processen har.

På apache2 på en debian variant er her anno 2024 fundet at denne user hedder www-data.

Uanset hvor komplekst detaljegrad system man bygger ovenpå, så er det stadig  www-data som er webserver user og ejer filer webserver processen skaber.

Hvorfor ikke så lade www-data 'skifte hat' - når Leo har autoriseret sig så bliver ejer www-data:leo og når det er Grete, www-data:grete. Leo og Grete er ikke users i OS forstand - der er de groups. I PHP system forstand blev det håndteret som usere. Kun Leo kan redigere og slette filer der i OS forstand har group leo som group. Read flaget på group nivea afgør om andre må se indhold. Leo kan oprette filer i directories der har leo som group og oprette directories som ligger i directories som har leo som group.  

Hvordan opretter Leo så grenens rod?  

For at agere users i PHP system forstand er der et login system med password.  
www-data er med på listen af users med login. Helt på samme måde kan www-data oprette, ændre, slette og i PHP systemisk forstand, skjule vha. group read flaget.  

login user www-data kan som den eneste user ændre group navnet på filer - og det er svaret på hvordan leo får sit udspring at oprette filer i.

Der er truffet det valg i HocusPucus at filer er www-data ejet - hvad der nævnt hidtil gik på groups. Derfor får de permission rw-rw-rw eller octalt 0666, så de også kan redigeres i text editor. Directories får permission octalt 0777.

usernavne er OS groups som ikke er OS users samt www-data.

EOMD,srcf('defines.php','APACHE',1,'function OSGroups'),<<<EOMD
$srcExpl
user www-data er også user.
</div>

Grupper oprettes og tilføjes den user, apache web server processen har.

```
# addgroup newuser
# usermod -a -G newuser www-data

# systemctl restart apache2
```
Ved oprettelse af datafil sættes gruppen til logged in user.

EOMD,srclf('progs/NNNAPI.php','function newFile','^$'),<<<EOMD

Dialog menuen key 'c' toogler mellem privat og public - kan iagtages i statusline.

EOMD,srclf('progs/NNNAPI.php','function toogle','^$'),<<<EOMD

Users kan oprette password og efterfølgende logge ind som en PHP user.

Passwords kan kun ændres ved, med fil adgang, at slette password for en user.  

Variabel \$_SESSION afspejler om der er en loggedin user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn',3),<<<EOMD
I dialog menuens html er et link der skifter mellem login og logged in user på hvilken der kan logges ud.

EOMD,srclf('actors/StdMenu.php','function hamMenu()',3,'\[\$ahref,\$atxt\] = isLoggedIn\(\)',3,'<a href=\'<\?=\$ahref',1),<<<EOMD

\$thisUrl bruges til at genåbne den side hvorfra login blev udført.

EOMD,srcf('progs/LoginRecieve.php','windowOldLocation',3,'class LoginRecieve',1,'function logout',3),<<<EOMD
$srcExpl
Efter at have fjernet user fra \$_SESSION genåbnes siden gennem javascript.
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

user, krypteret password og salt der indgår i kryptering gemmes i php AUTHFILE som array, __hvis__ user finde i constant array USERS, og ikke allerede findes i AUTHFILE.
</div>

EOMD,srclf('progs/LoginRecieve.php','function oneauth',11),<<<EOMD
$srcExpl
\$_SESSION[LOGGEDIN] sættes til user listet i USERS som logger ind med password som passer med det i AUTFILE, ellers sættes \$_SESSION[LOGGEDIN] til den tomme streng.
</div>

#### AUTHFILE
I AUTHFILE er usere key til par af encryptet password og salt - alt i et array. Det har syntaksen på et PHP array så det kan indlæses med include. Ved sletning af users skal det påses at resterende stadig er et gyldigt array.

_config/encrypted.php_
```
<?php return array (
    'leo' =>
    array (
      0 => '65weOMddagfWf',
      1 => '65b3963a508f0',
    ),
    'grete' =>
    array (
      0 => '65lew3AWqfivw',
      1 => '65b396550a94d',
    ),
    'www-data' =>
    array (
      0 => '65nlYh2WUQ6zQ',
      1 => '659abd9c9e545',
    ),
  );
```
### Automatisk login
Alt ovenstående er blot for, f.eks, at udføre
```
\$_SESSION[LOGGEDIN]=USERS[n]; // 0 ≦ n < antal usere
```
Authentication er begrænsning af adgangsvejen til at tildele til \$_SESSION[LOGGEDIN].   

Authentication er relevant ved online adgang. For at kunne slette, ændre og editere skal man være loggedin og datafiler oprettes med loggedin user som flaget ejer.   

Hvis HocusPocus bruges med adgang til webdir kan det laves sådan at der automatisk 'loggges ind' på en konto.

EOMD,srclf('globalfuncs.php',"array_key_exists\(LOGGEDIN",7),actors\tocNavigate($func)];
