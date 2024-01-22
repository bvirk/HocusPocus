<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func),<<<EOMD
mv and mvDir are the same in the dialog menu, but if target for renaming is a directory mvDir is called. This is therefore a matter of renaming within the same directory.  
Renaming a directory results in
1. Directory as 'datadir' is renamed
2. the corresponding class is renamed.
3. if the directory the class is in also has a directory with the same name as the class but lowercase as the first character, then:
     1. rename this directory to the new name
     2. The namespaces part in all classes in the new directory tree is changed to the new name.
4. img path renames.
5. css and js path elements renames.

EOMD,actors\srclf('progs/NNNAPI.php','function mvDir','18'),<<<EOMD

EOMD,actors\tocNavigate($func)];