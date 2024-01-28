<?php
use function actors\srclf;
$filetoeditUrl=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/progs/html/source/file=config/filetoedit|txt';
$url = implode('/',$pe);
$classFile = implode('/',array_slice($pe,0,-2)).'/'.ucfirst($pe[count($pe)-2]).'.php';
$datadir = <<<EOMD
data
└── pages          
    └── da   
        ├── alterego
        │   └── index.md
        ├── index.php
        └── sysler
            └── programmer
                ├── hocuspocus
                │   ├── ajax.md
                │   └── index.md
                └── index.md
EOMD;
$pagesdir= <<<EOMD
pages
└── da
    ├── Alterego.php
    ├── sysler     
    │   ├── programmer
    │   │   └── Hocuspocus.php
    │   └── Programmer.php
    └── Sysler.php                  
EOMD;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
EOMD,srclf('index.php','require',1)
    ,srclf('globalfuncs.php','require',1)
    ,srclf('defines.php',1,2,'PAGES_ROOT',1)
    ,srclf('HocusPocus.php','abstract class',1),<<<EOMD

### actors
Class hierarchy resides in actors. A class instantiated by a request whose url starts with domain/pages/ inherits from an actors class. The name is an abbreviation of ancestors.  

EOMD,srclf('actors/PageAware.php','namespace',4)
    ,srclf('actors/StdMenu.php','namespace',1,'class StdMenu',1),<<<EOMD

### config
The file selected for editing in the dialog menu or PHP error caught by javascript AJAX
[filetoedit.txt]($filetoeditUrl)

### css
All css files are located in directories that correspond to different addresses from the url and class hierarchy.

### data
In data there is a file for each html document. Url, class file and data file are closely related. The following applies to this page:

|           |   |           |
|:--        |:--|:--        |
|url        |∣  |$url       |
|datafile   |∣  |$incPath   |
|class File |∣  |$classFile |
|image dir  |∣  |$imgPath   | 
EOMD, srclf($incPath,'implode',2,'\|:--',5),<<<EOMD

Tree clips show how data and pages interact.

```
Directory
$datadir

Directory
$pagesdir
```
Index must exist for group of pages - either as data file index.md or index.php or as method.

### datavars
Datavars contain actor class specific variables for use in datafiles. It is html strings that in this way get a 'single point of source' and make writing shorter. For the file behind this page applies  

EOMD,srclf($dataVarsFile,1),<<<EOMD

### /etc/apache2/mods-enabled
Besides a lot of common stuff, mod_rewrite - the file is called:
-  rewrite.load 

### /etc/apache2/sites-enabled
Config file for virtual host has a Directory section. The site __should__ have /pages/da/index and /pages/en/index. With these redirections and the mechanisms in index.php and HocusPocus.php, every imaginable url is captured and either displayed or redirected to /pages/en/index. Last RewriteRule is all the magic that calls default index.php with the entire path part of the url as the query string parameter path being this.

```
<Directory /var/www/mydomain>
Options Indexes FollowSymLinks
AllowOverride All
Require all granted
RewriteEngine on
RewriteRule ^pages$ /pages/en/index [R=302]
RewriteRule ^pages/en$ /pages/en/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=$1
</Directory>
```



### img
Each page has its image directory under img/ and the variable \$imgPath points to it. When deleting (trashing) a page in the dialog menu, the directory \$imgPath and all files therein are trashed.

[![imagemagick]($imgPath/imgMagicklogo.png)](https://imagemagick.org)

### js
All js files are located in directories that correspond to different addresses from the url and class hierarchy.  
For a given pathname of a file with the extension js, if it is not found, a corresponding pathname with the extension php is searched.  
In this way, the directory tree beneath js/ contains files with the extension js or php

### jsmodules
In jsmodules is the directory jsmodules/jslib. Files in jslib are parameterized for general use - e.g. contains no context from individual pages or classes.  
The name of a page's most inherited actor class is also the name of the directory in jsmodules/ that contains main.js for this actor class

EOMD,srclf('js/PageAware/StdMenu.php','use function',1,'Nasty',1,'module',1),<<<EOMD

### pages
All pages are a page under a pages class - the one instantiated in index.php. All pages originate from an actors class and are not included as a base class in other page classes.
It is through the namespace categorization that the url designates in a smaller part members of hierarchies. Page classes are typically empty, containing only the namespace and the class declaration designating the base class.
However, it is possible to add methods, but this has not been used

### progs
progs is to data/progs as pages is to data/pages. With the same mechanisms as for page pages, data can be retrieved and html documents created. progs are dedicated to everything else and pages such as API.  

### trash
In the dialog menu, directories and files in the data directory can be deleted - i.e. transferred to trash. Everything related that is also transferred is:
- pages classes that no longer has associated data
- css og javascript which no longer belongs
- images and img directories

It is with the complete path, so everything that is trashed is 'renamed' with trash/ directory in front of the original path from the document root.  
It can be re-established from trash - it has been given key: 'z' in the dialogue menu. That is all that is reestablished - the individual trashings do not interfere with each other as they are distinct.  

[/progs/emptyTrash](/progs/emptyTrash) er en magick url der tømmer trash.

### utilclasses
EOMD,srclf('utilclasses/Parsedown.php',1,12),srclf('utilclasses/Sitemap.php','class Sitemap',1,'function dirlisthtml',5),<<<EOMD
$srcExpl
Sitemap with html &lt;ul&gt; and &lt;li&gt; tags using recursive descent in /data/pages. Directories are links to index.  
</div>
EOMD,srclf('utilclasses/SrcLister.php',2,7,'function lines',1),<<<EOMD
$srcExpl
Which makes it possible to show source code like this
</div>

EOMD,srclf('actors/Pagefuncs.php','showFilenameHeadEnum',6,"new \\\\utilclasses",1,'basename source',26),
actors\tocNavigate($func)];


