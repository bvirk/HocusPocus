<?php
use function actors\srcf;
use function actors\srclf;

return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
OSes have process identification with ownership. Anyone who requests any web page is in a way logged in.  

An arbitrary request on some of the normal OSes happens as a basic user with ownership of files - the user the web server process has.  

On apache2 on a debian variant, here in 2024 it was found that this user is called www-data.  

No matter how complex the level of detail the system is built on top of, it is still www-data that is the web server user and owns files the web server process creates.  

Why not let www-data 'change hats' - when Leo has authorised, the owner becomes www-data:leo and when it's Grete, www-data:grete. Leo and Grete are not users in the OS sense - they are groups. In the PHP system sense it is handled as users. Only Leo can edit and delete files that in the OS sense have group leo as group. The read flag on group level determines whether others can see content. Leo can create files in directories that have leo as group and create directories located in directories that have leo as group.

But how do Leo create the toplevel directory?  

To act as a user in the PHP system sense, there is a login system with a password.  
www-data is included in the list of users with login. In exactly the same way, www-data can be created, changed, deleted and, in a PHP systemic sense, hide using the group read flag.  

login user www-data, as the only user, can change the group name of files - and that is the answer to how leo gets its origin in creating files.  

The decision has been made in HocusPucus that files are owned by www-data - what was mentioned so far went to groups. Therefore, they get permission rw-rw-rw or octal 0666, so they can also be edited in a text editor. Directories get permission octal 0777.  

HocusPucus user names are OS groups that are not OS users.

EOMD,srcf('defines.php','APACHE',1,'function OSGroups'),<<<EOMD
$srcExpl
user www-data er også user.
</div>

Groups are created and added to the user the apache web server process has.

```
# addgroup newuser
# usermod -a -G newuser www-data

# systemctl restart apache2
```
When creating a data file, the group is set to logged in user.  

EOMD,srclf('progs/NNNAPI.php','function newFile','^$'),<<<EOMD

The dialog menu key 'c' toggles between private and public - can be seen in the status line.

EOMD,srclf('progs/NNNAPI.php','function toogle','^$'),<<<EOMD

Users can create a password and subsequently login in as a PHP user.

Passwords can only be changed by deleting a user's password with file access. A session cookie registers the logged in user. No permanent cookies are used.

Variable \$_SESSION reflects whether there is a logged in user
EOMD,srcf('actors/Pagefuncs.php','function isLoggedIn',3),<<<EOMD
In the dialog menu's html is a link that switches between login and logged in user, which can be used to log out.

EOMD,srclf('actors/StdMenu.php','function hamMenu()',3,'\[\$ahref,\$atxt\] = isLoggedIn\(\)',3,'<a href=\'<\?=\$ahref',1),<<<EOMD

\$thisUrl is used to reopen the page from which the login was performed.

EOMD,srcf('progs/LoginRecieve.php','windowOldLocation',3,'class LoginRecieve',1,'function logout',3),<<<EOMD
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
In AUTHFILE, users are key to pairs of encrypted password and salt - everything in one array. It has the syntax of a PHP array so it can be loaded with include. When deleting users, it must be ensured that the remainder is still a valid array.

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

### Automatic login

Everything above is just to, e.g., to perform
```
\$_SESSION[LOGGEDIN]=USERS[n]; // 0 ≦ n < antal brugere
```
Authentication is restricting the access path to assign to \$_SESSION[LOGGEDIN].  

Authentication is relevant for online access. In order to delete, change and edit, you must be logged in and data files are created with the logged in user as simulated owner.

If HocusPocus is used with access to webdir, it can be made so that an account is automatically 'logged in'.

EOMD,srclf('globalfuncs.php',"array_key_exists\(LOGGEDIN",7),actors\tocNavigate($func)];
