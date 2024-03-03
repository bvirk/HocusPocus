<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
StdMenu has the dialog with which the site is administered. The word StdMenu is on the way out - it was once a Menu that could do something special - it has gradually become more of a file manager dialog than a menu.

EOMD,srclf('actors/StdMenu.php','namespace pages',1,'class StdMenu',8),<<< EOMD
$srcExpl

the dialog is attached to the div id with class="modal" using javascript. In this way, the html source appears more clearly.  
When you click or key enter on a page from the dialog, the html source becomes prettyfied.
</div>

### Transfer of context from PHP til javascript

EOMD,srclf('js/PageAware/StdMenu.php','script','^$'),<<< EOMD

### The html source of the dialog
EOMD,srclf('jsmodules/StdMenu/main.js','let dlgHtml','^$'),<<< EOMD

#### Html tags inside the dialog
The dialog is splitted in three columns through styling

##### Left column:
EOMD,srclf('jsmodules/StdMenu/main.js','span title="Home page"',2),<<< EOMD
$srcExpl
The two span elements is a link to the root and a back link to upper directory
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='curDirStr'",1),<<< EOMD
$srcExpl
Path for current directory.
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='wdFiles'",1),<<< EOMD
$srcExpl
ul elements i which javascript inserts current directories files
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',"id='statusLine'",1),<<< EOMD
$srcExpl
Status line, which is used for various feedback and e.g. attributes for selected file in the dir list
</div>

EOMD,srclf('jsmodules/StdMenu/main.js','onsubmit',6),<<< EOMD
$srcExpl
Html form becomes visible for input of file or dir name for creation or renaming, and confirmation or abort for deletion of file or dir
</div>


##### Middle column:


EOMD,srclf('jsmodules/StdMenu/main.js',"a href",1),<<< EOMD
$srcExpl
Login/logout link using variables from js/PageAware/StdMenu.php linie 22
</div>


EOMD,srclf('jsmodules/StdMenu/main.js',"editmode",2),<<< EOMD
$srcExpl
Choice of edit way using variables from js/PageAware/StdMenu.php linie 23
</div>

##### Rigth  column:
EOMD,srclf('jsmodules/StdMenu/main.js',"id='close'",2),<<< EOMD
$srcExpl
Just close button at top
</div>

It was about the html which 'becomes alive' as a result of javascript additions, changes and visibility in the html. It is triggered by keys that are captured in keyhandlers and query the web server using AJAX and PHP.  

First an attempt to explain API in a simple way.

EOMD,actors\tocNavigate($func)];