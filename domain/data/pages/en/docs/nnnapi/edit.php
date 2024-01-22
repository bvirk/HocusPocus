<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD

Edit, key 'e' in the dialog menu saves the name of the file which has focus in config/filetoedit.txt. With access to webdir the file can be opened in an editor with e.g. [wed](https://raw.githubusercontent.com/bvirk/localebin/main/wed). wed calls [ced](https://raw.githubusercontent.com/bvirk/localebin/main/ced) which opens in visual studio code. The file can also be opened for editing in browser.
##### config/filetoedit.txt
```
$ cat config/filetoedit.txt
_ /var/www/vps/domain/data/pages/da/sysler/programmer/hocuspocus/nnnapi.php
```
$srcExpl
filetoedit.txt after key 'e' in the dialog menu on the file in which this text is written.
</div> 

filetoedit.txt has two uses
- name of file to be edited
- PHP error message, file and line number for errors

the format is a line with 2 space-separated fields:
1. message encoded with '_' for spaces
2. filename or filename:line number

EOMD,srclf('progs/NNNAPI.php','function edit','7'),<<<EOMD
$srcExpl

If it is a directory that has focus in the dialog menu, the index is found there.  
The javascript that receives the response opens, depending on the value of \$_SESSION['editmode'], login or whether the webdir is local or not, \$fileToEdit for editing in the browser.
</div>

EOMD,actors\tocNavigate($func)];