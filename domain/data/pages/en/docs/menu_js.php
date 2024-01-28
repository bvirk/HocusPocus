<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
The dialog menu has onClick events so that you can navigate with a pointing device, but file handling is only possible with the keyboard.

### The modules
The dialog menu belongs to class StdMenu. That means follwing is fetched:  
EOMD,srclf('js/PageAware/StdMenu.php','Nasty',1,'jsmodules\/StdMenu\/main\.js',1),<<<EOMD
$srcExpl
main.js is located in a directory that has the same name as the class it belongs to.
</div>

EOMD,srclf('jsmodules/StdMenu/main.js',1),<<<EOMD
$srcExpl

request.js has path ../jslib while the other files are in the same directory as main.js  
Everything imported in main.js is used to attach functions to object allFuncs which can thus be called by being assigned html onCLick attributes.
</div>

The dividing line between whether a javascript file is in the same directory as main.js or in jslib is whether it contains context from the current application or is fully parameterized.

- formsubmit
     - common request sending for commands with prompt for file or dir name.
- himMenu
     - draws content in the dialog menu.
- keyboard
     - captures keyboard events and exposes change of keyboard event function.
- main
     - binds onClick event to functions.
- request
     - two request functions, one for GET and one for POST.
- reqCallBacks
     - five functions that receive a response.

#### The request
A request is captured by the API, which is implemented in PHP, and the response is received by a javascript function.
EOMD,srclf('jsmodules/jslib/request.js','let  httpRequest',11),<<<EOMD
$srcExpl
The request is conveyed by the XMLHttpRequest object - property onreadystatechange is assigned to the function that must receive a response to the request.  
</div>

To get a single point of source, a constant is used everywhere as the first argument to request(...)
EOMD,srclf('jsmodules/StdMenu/hamMenu.js','const APIName',1),<<<EOMD
$srcExpl
It follows that the argument string, which is '&' seperated 'key=value' pairs, must be preceded with '&'
</div>

### Opening of the dialog menu
The hamburger icon's onClick attribute has a function
EOMD,srclf('jsmodules/StdMenu/main.js','hamDrawMenu = hamDrawMenu',1),<<<EOMD
The dialog menu can also be opened by F9
EOMD,srclf('jsmodules/StdMenu/keyboard.js','function whenNoMenu',7)
    ,srclf('jsmodules/StdMenu/hamMenu.js','let menuIsVisible',2,'function hamDrawMenu',9,'function hideInput',3),<<<EOMD
$srcExpl

setCurkeyhandler switches to keyboard handler navigate(event).  

Global variable curDirStr is used in navigating up and down directories.  

Javascript location.pathname  comes with leading slash and curDirStr is without.  
We never sees location.pathname being '/' beacuse of redirection of the bare domian.  

The last link in the url's path is the datafile. It is the directory in which the datafile is located, that must be displayed - therefore the last path element in curDirStr is removed.  

Visibility of the dialog menu using property value block for display 

hideInput hides the prompt and its ability to send POST request.

The rest of the dialog menu drawing is done in showMenu with the result of API call to method ls.

showMenu() is continuously called to redraw, but only here with the flag isFirstDraw=true to set the cursor on the data file that drew the page in which the dialog menu was opened.
</div>

Response of [ls](nnnapi/ls), which returns an array of arrays of properties for each file, is received by showMenu
EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function showMenu',27,'function catchResp',13),<<<EOMD
$srcExpl

Any response function must be preceded by 'if (httpRequest.readyState ....) return;' - otherwise it won't work.  

In contrast, retrieval in try catch, with differentiation between json parseable and signaled php error, is the same for all five response functions, so it is delegated to function catchResp.  

A button with id: navBack is made visible when curDirStr is longer than 'pages' ('pages' is the top directory)  

showMenu() is called every time the dirlist needs to be updated, so &lt;ul&gt; with id: wdFiles is initially cleared.  

In the loop, the file list is built up as links in &lt;li&gt; tags.  
curDir is an array of arrays of file properties received from the API call 'ls'. From the fact that curDir[index][1] is '/' for directories and '' for files, variables look, href and clknav are assigned for the appearance of each file as a link, its href attribute and its possible folder button. Each a element also has an id called pid followed by index.  

curDirStr is also the id of a &lt;div&gt; which is then also displayed.
</div>

showMenu calls at last initDomElements().

EOMD,srclf('jsmodules/StdMenu/hamMenu.js','function initDomElements',14),<<<EOMD
$srcExpl

lid contains the array of DOM elements used to select a file.

cid, for current id, is index in lid as an integer. cid is set to 0, or, if isFirstDraw=true, index to the file which is the data file for the page where the dialog menu was opened.  
'const index in curDir' are strings, hence the small '+' to assign integer to cid.

statusline(...) shows a description of the selected file, in the format known from the file manager nnn.

lidInverse() highlights selected file by swapping character and background colors.
</div>

###### future subjects in this chapter 
- statusline
- navigation
- other keys
- prompting for txtinput
- POST, submit form and savefile
- how to catch 2 keys for one action - perhaps redesign with additional event function
- reqcallbacks which has not been mentioned.


EOMD,actors\tocNavigate($func)];