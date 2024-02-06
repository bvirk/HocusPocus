<?php
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Re-establish from trash. Reestablishment from multiple trashings does not conflict as they are distinct. Links are renamed. Several undoTrash in succession have no effect as copy just overwrites and links are no longer in trash.
EOMD,actors\srclf('progs/NNNAPI.php','function undoTrash','^$'),<<<EOMD
$srcExpl
IS_PHP_ERR is used to show the statusline in the dialog menu.
</div>

The strategy for trashing is to move, prefixing any file realtive pathname from the document root, with trash/. Thus, everything is trashed with their original path - and can be re-established by copying to a destination without prefixed trash.
EOMD,actors\srclf('progs/NNNAPI.php','function copySubDirsOf','^$'),<<<EOMD
$srcExpl
\$rootLen points so far into \$file that the front 'trash/' is not included in the destination for copying files or renaming links.
</div>

EOMD,actors\tocNavigate($func)];