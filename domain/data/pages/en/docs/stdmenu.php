<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD

EOMD,srclf('actors/StdMenu.php','namespace pages','1','class StdMenu','8'),<<< EOMD
$srcExpl

hamMenu() creates the html that is placed before the part of the body element that is laid out from data
</div>

### function hamMenu()

#### The action that opens the dialog menu

EOMD,srclf('actors/StdMenu.php','id="hammenu"','1'),<<< EOMD
$srcExpl
A button with a hamburger unicode character and the name of the function that opens a dialog
</div>

EOMD,srclf('js/PageAware/StdMenu.php','allFuncs','1',"type='module'",'1'),<<<EOMD

EOMD,srclf('jsmodules/StdMenu/main.js','hamDrawMenu','1','allFuncs.hamDrawMenu','1'),
srclf('jsmodules/StdMenu/hamMenu.js','function hamDrawMenu','1','myModal','1'),<<<EOMD
$srcExpl
Only the css property assignment that makes the dialog menu visible is shown here
</div>

EOMD,srclf('actors/StdMenu.php','id="myModal"','2'),<<< EOMD
$srcExpl
The dialog menu's enclosing div - inside is the html that gives it content.
</div>

#### Html tags inside the dialog menu
The dialog menu is divided into three columns through styling.

#####variables

EOMD,srclf('actors/StdMenu.php','isLoggedIn','3'),<<< EOMD
$srcExpl
variables for text and url links for login/logout.
</div>

EOMD,srclf('actors/StdMenu.php','DEFAULTEDITMODE','3'),<<< EOMD
$srcExpl
Icon for choosing whether editing should take place in the browser or not (only file ref as local editor is accessed)
</div>

##### Left column:
EOMD,srclf('actors/StdMenu.php','span title="Home page"','2'),<<< EOMD
$srcExpl
The two span elements - a link to the root and a backlink.
</div>

EOMD,srclf('actors/StdMenu.php',"id='curDirStr'",'1'),<<< EOMD
$srcExpl
Path for current directory.
</div>

EOMD,srclf('actors/StdMenu.php',"id='wdFiles'",'1'),<<< EOMD
$srcExpl
ul element in which javascript inserts the current directory's files
</div>

EOMD,srclf('actors/StdMenu.php',"id='statusLine'",'1'),<<< EOMD
$srcExpl
Status line, which is used for various feedback and e.g. attributes for selected file in the dir list
</div>

EOMD,srclf('actors/StdMenu.php','form onsubmit','5'),<<< EOMD
$srcExpl
Html form becomes visible for input of file or dir name for creation or renaming, and confirmation or abort for deletion of file or dir
</div>


##### middle column:


EOMD,srclf('actors/StdMenu.php','a href','1'),<<< EOMD
$srcExpl
Login/logout link using variables from line 6
</div>


EOMD,srclf('actors/StdMenu.php','editmode:','2'),<<< EOMD
$srcExpl
And selection of edit mode using variables from line 10
</div>

##### Right column:
EOMD,srclf('actors/StdMenu.php',"id='close'",'3'),<<< EOMD
$srcExpl
Only close button at top.
</div>

It was about the html in the function hamMenu(). It explains nothing about how the interactivity is provided, because that is javascript and AJAX. Before we look at this, a demo with simpler mechanics follows in the next chapter.

EOMD,actors\tocNavigate($func)];