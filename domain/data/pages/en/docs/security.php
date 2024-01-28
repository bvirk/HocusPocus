<?php
return ["<!<div class='auto80'>#html#</div>" ,actors\tocHeadline($func),<<<EOMD
With previously assigned apache configuration, directory listing is blocked by redirection - but files that are not .php files can be read. As such, it doesn't matter much since HocusPocus does not use config files, but the matter must be investigated anyway.

HocusPocus can be set so that non-existing pages cause redirection to the default page
EOMD,actors\srclf('HocusPocus.php','noDataAvail',3,'function noDataAvail',5),<<<EOMD
$srcExpl
When commenting is set in developer mode, found pages are not redirected to the default page.
</div>

#### Directory listning
- [root](/)
    - ok. Default page by redirection i index.php
- [/data/pages](/data/pages)
    - redirection error
- [/config](/config)
    - redirection error

#### Ikke php filer
- [/config/filetoedit.txt](/config/filetoedit.txt)
    - visible
- [/css/da.css](/css/da.css)
    - browser viser tom side
- [/js/da.js](/js/da.js)
    - visible
- [/img/pages/da/docs/dirs_and_files/imgMagicklogo.png](/img/pages/da/docs/dirs_and_files/imgMagicklogo.png)
    - picture is showed
- [/data/pages/da/docs/nnnapi/index.md](/data/pages/da/docs/nnnapi/index.md)
    - visible by browser offers to save
- [/jsmodules/jslib/request.js](/jsmodules/jslib/request.js)
    - visible

### php filer
The different types are evaluated. functions and classes can be defined, but without something outside functions and classes to call or instantiate, nothing is outputtet.

- [/progs/EmptyTrash.php](/progs/EmptyTrash.php)
    - nothing
- [/globalfuncs.php](/globalfuncs.php)
    - session sættes så loggedin user på LAN bliver USERS[/0] og default language gennem i session
- [/HocusPocus.php](/HocusPocus.php)
    - nothing
- [/actors/PageAware.php](/actors/PageAware.php)
    - pga class enheritance: 'Fatal error: Uncaught Error: Class "HocusPocus" not found'
- [/actors/Pagefuncs.php](/actors/Pagefuncs.php)
    - nothing
- [/config/encrypted.php](/config/encrypted.php)
    - nothing
- [/data/pages/da/docs/index.php](/data/pages/da/docs/index.php)
    - nothing
- [/datavars/PageAware/StdMenu.php](/datavars/PageAware/StdMenu.php)
    - nothing
- [/pages/da/Docs.php](/pages/da/Docs.php)
    - pga class enheritance: 'Fatal error: Uncaught Error: Class "actors\StdMenu" not found'

### conclusion
No need to exclude access to file reading - for config/encrypted.php the variable in the request might exist in PHP, but without something that can use this runtime it won't be exposed.


EOMD,actors\tocNavigate($func)];