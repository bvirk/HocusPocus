<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
OSes have process identification with ownership. Anyone who requests any web page is in a way logged in - also on a static page without cookies or local storage.  
You normally put the authorized person-directed in the term logged in, but in fact an arbitrary request on some of the normal OSes cannot happen without being a user with ownership.  

On apache2 on a debian variant, here in year 2024 it was found that this user is called www-data.  

No matter how complex and detailed the logged in system is, www-data is still the owner.  

Why not just let www-data 'change hats' - when hansel has been authorized, the owner becomes www-data:hansel and when it's gretel, www-data:gretel.

HocusPucus user names are OS groups that are not OS users.

EOMD,srcf('defines.php','function OSGroups'),<<<EOMD

Groups are created and added to the user the apache web server process has.

```
# addgroup newuser
# usermod -a -G newuser www-data

# systemctl restart apache2
```
Users' ownership of a data file is simulated by the file's group name being user the name - and public versus private with the read flag for group access.  

When creating a data file, the group is set to logged in user.  

EOMD,srclf('progs/NNNAPI.php','function newFile',2,'return chgrp\("data\/\$file"','^$'),<<<EOMD

The dialog menu key 'c' toggles between private and public - can be seen in the status line.

EOMD,srclf('progs/NNNAPI.php','function toogle','^$'),<<<EOMD

Users can create a password and subsequently login in a PHP registration which has __nothing__ to do with OS level passwords.  

Passwords can only be changed by deleting a user's password with file access. A session cookie registers the logged in user. No permanent cookies are used.


Variable \$_SESSION reflects whether there is a logged in user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn',3),<<<EOMD
In the dialog menu's html is a link that switches between login and logout.

EOMD,srclf('actors/StdMenu.php','<\?=\$ahref',1,'thisUrl',4),<<<EOMD
EOMD,srcf('progs/LoginRecieve.php','windowOldLocation',3,'function logout',3),<<<EOMD
$srcExpl
After removing user from \$_SESSION the page is reopened through javascript.
</div>

As a feedback, the dialog menu, provided by a cookie based flag, is opened.

EOMD,srcf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu',2)
    ,srcf('js/PageAware/StdMenu.php','function\(\)',4),<<<EOMD
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

EOMD,srclf('progs/LoginRecieve.php','function saveEncryption',14),<<<EOMD
$srcExpl

User, encrypted password and salt are stored in php AUTHFILE as an array, __if__ user can be found in constant array USERS, and is not already found in AUTHFILE.
</div>

EOMD,srclf('progs/LoginRecieve.php','function oneauth',11),<<<EOMD
$srcExpl
\$_SESSION[LOGGEDIN] is set to the user listed in USERS who logs in with a password that matches the one in AUTFILE, otherwise \$_SESSION[LOGGEDIN] is set to the empty string.
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
\$_SESSION[LOGGEDIN]=USERS[n]; // 0 ≦ n < antal brugere
```
Authentication is restricting the access path to assign to \$_SESSION[LOGGEDIN].  

Authentication is relevant for online access. In order to delete, change and edit, you must be logged in and data files are created with the logged in user as simulated owner.

If HocusPocus is used with access to webdir, it can be made so that an account is automatically 'logged in'.

EOMD,srclf('globalfuncs.php',"array_key_exists\(LOGGEDIN",7),actors\tocNavigate($func)];
