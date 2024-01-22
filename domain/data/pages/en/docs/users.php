<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
The user concept is rudimentary with a hardcoded list. Users can create a password and subsequently log in. Passwords can only be changed by deleting a user's password with file access. A session cookie registers the logged in user. No permanent cookies are used.

EOMD,srcf('defines.php','USERS','1'),<<<EOMD


Variable \$_SESSION reflects whether there is a logged in user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn','3'),<<<EOMD
In the dialog menu's html is a link that switches between login and logout.

EOMD,srclf('actors/StdMenu.php','<\?=\$ahref','1','thisUrl','4'),<<<EOMD
EOMD,srcf('progs/LoginRecieve.php','windowOldLocation','3','function logout','3'),<<<EOMD
$srcExpl
After removing user from \$_SESSION the page is reopened through javascript.
</div>

As a feedback, the dialog menu, provided by a cookie based flag, is opened.

EOMD,srcf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu','2')
    ,srcf('js/PageAware/StdMenu.php','function\(\)','4'),<<<EOMD
$srcExpl
It is the ready function that jquery provides - run when the page is loaded
</div>

### Login form

The html form element enables signin and signup. A button click switches between the two things.

EOMD,srclf('data/progs/html/login.php',1),<<<EOMD
$srcExpl

Variables are assigned so that the form becomes signin or signup - basically signin unless the encryption file 'is empty'.  
\$_GET['url'] is reposted to be able to open the same page from which login/logout/register was activated.
</div>

EOMD,srclf('progs/LoginRecieve.php','function saveEncryption','14'),<<<EOMD
$srcExpl

User, encrypted password and salt are stored in php AUTHFILE as an array, __if__ user can be found in constant array USERS, and is not already found in AUTHFILE.
</div>

EOMD,srclf('progs/LoginRecieve.php','function oneauth','11'),<<<EOMD
$srcExpl
\$_SESSION['loggedin'] is set to the user listed in USERS who logs in with a password that matches the one in AUTFILE, otherwise \$_SESSION['loggedin'] is set to the empty string.
</div>

#### AUTHFILE
In AUTHFILE, users are key to pairs of encrypted password and salt - everything in one array. It has the syntax of a PHP array so it can be loaded with include.

_config/encrypted.php_
```
<?php
// Deleting all password by delete from line 4, but keep last line. NO TRAILING EMPTY LINES 
return [
'final' => ['65nlYh2WUQ6zQ','6599e9df16cb4']
,'bob'=>['65IYvsRzipQ2U','659abd9c9e545']
];
```
### Automatic login
Everything above is just to, e.g., to perform
```
\$_SESSION['loggedin']=USERS[0];
```
Authentication is restricting the access path to assign to \$_SESSION['loggedin'].  

Authentication is relevant for online access. To be able to create, delete, change and edit, you must be logged in.  

If HocusPocus is used with access to the webdir it's a bit of a show - although it's done easily.  

Therefore, you are automatically logged in if no one else is logged in __and__ there is an indication of having file system access to webdir - on a browsing computer or LAN.

EOMD,srcf('globalfuncs.php','automatically logged','3'),<<<EOMD
The link text in the dialog menu does not show 'logout' in front of USERS[0] - you can still click on it and be logged out of USERS[0].
EOMD,srclf('actors/StdMenu.php','isLoggedIn','3'),srcf('defines.php','USERS','1'),actors\tocNavigate($func)];