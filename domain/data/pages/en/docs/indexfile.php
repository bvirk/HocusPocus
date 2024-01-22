<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
The data file index (.md or .php) has a special role.  

All url paths end with an existing method or data file. Any instantiation in index.php takes place in the context of executing the method which is the last path element of the url path. It must exist either as a method or as a data file.
It is determined that HocusPucus must not have classes that cannot be instantiated in index.php - therefore all classes must have, as a minimum, either a method index or a related datafile index

Index is the default method or datafile. In the dialog menu, clicking on a directory addresses the page with method index or datafile index. (not on the icon but the name). The same for the file that has focus - if there is a directory and you press return, the index page is opened

### Creation of pages
When creating a directory in the dialog menu, following happends in addition to creation of the directory

- index.md underneath with rudimentary standard content is created
- pages class inheriting from the standard arctor class is created under pages/

### Delete index and directory (transfer to trash)
Deleting the index is the same as deleting the directory in which it is located. When deleting, which is a transfer to trash, everything related is trashed: images, css, js, php class and javascript.

### Url with two path elements

For pages it fell into three cases: pages/da, pages/en and pages/whatevernonesense - it all leads to a default page for a language.  

It is more interesting for progs classes. It is used to create magick urls which are addressed with only two path elements

EOMD,srclf('index.php','used for 2 path element','2'),srclf('progs/EmptyTrash.php','namespace','4'),<<<EOMD
$srcExpl
Url = progs/emptyClass as third path element index is added in index.php
</div>   

It can be used for administrative tools.

### Unwanted index

As a narrative, the index can be undesirably meta-like. There are several things in turning the index into a symbolic link to one of the other pages.  
It is another page of the same class and thus also the same datafiles directory, which is meant by 'one of the other pages'  

domain/progs/lnIndex is a magic url to do that.

EOMD,srclf('progs/LnIndex.php','targetWOE','6'),<<<EOMD
$srcExpl

Must be called with parameter target, but without extension such as /?path=progs/lnIndex&target=da/sysler/drama/gearbox to associate index with gearbox. There is a free choice between specifying the target entirely from the document root or from data/ or data/pages/  
Note that the query string way is required to call with parameters.
</div> 

EOMD,srclf('progs/LnIndex.php','link = false','20'),<<<EOMD
$srcExpl

Extension is determined for target and link. Should the index already be a symbolic link, it does not matter.
</div> 

EOMD,srclf('progs/LnIndex.php','function lnRel','6'),<<<EOMD
$srcExpl

PHP's symlink, when the current working directory (cwd) is other than the targets directory, does not facilitate making symbolic links relative to the target.  

Hence the function lnRel which provides two things
- cwd is left untouched as it is set back to the document root as required by the call of lnRel
- if the link already exists, the symlink is not executed.
</div> 

EOMD,srclf('progs/LnIndex.php','imgDir','3'),<<<EOMD
$srcExpl

index shall show targets pictures too.
</div> 

EOMD,srclf('progs/LnIndex.php','startDir','5'),<<<EOMD
$srcExpl

The css and javascript that apply specifically to target must also apply to index.
</div> 

EOMD,actors\tocNavigate($func)];