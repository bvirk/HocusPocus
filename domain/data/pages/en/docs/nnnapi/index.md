<?php
use function actors\srclf;
use function actors\srcf;

return ["<!<div class='auto80'>#html#</div>",<<<EOMD
## NNNAPI

[nnn](https://github.com/jarun/nnn/wiki) is a text-based linux file manager that is keyboard operated and has some intuitive keys for common file operations.  
One of its characteristics is that it is menuless and therefore easy, GUI-wise, to imitate as a dialog menu in a browser.  

The dialog menu is javascript based and serviced by NNNAPI in php.  

It is the data/pages directory tree that the dialog menu can pan around in, but file operations are complex and involve css/, js/, pages/ and img/pages as well. File operations such as create, rename and delete can include several files and/or their contents - things that would be tedious and easy to do wrong manually are thus ensured to be done consistently.  

To return is used in the following about echo in the PHP API source code - because it is, seen from the javascript function that handles the response, a return from the  API call.

### PHP structuring
NNNAPI.php is the largest file in HocusPocus - and the one that has undergone the most tedious restructuring.  

The old-fashioned true/false return values for PHP file operations functions are not used - it has been tested that PHP 8 can throw source code line number decorated exceptions instead - it's probably not wildly detailed with 'stat failed', but rather that than the uncertainty of the correctness of 100s of lines of home-made falbalas.  

All api calls are a method and there are no methods that are not an api call - most api calls delegate to functions - void for file operations and boolean for self-echoing context tests.  
Functions for context testing about ownership, file types and syntax etc. are logical or coupled domino bricks that keeps falling as long as false is returned. A true stops futher step in the API method with a return and with the notorious true returning test having echoed the message which will be caught by javascript.  
This entails some use of the operand _not_, because the test statement itself is semantically kept free from negation. A test's return value is the answer to its statement.
EOMD,srclf('progs/NNNAPI.php','function mv\(\)','^$'),<<<EOMD
$srcExpl

hasWriteAccess() returns false if something implicitly does not have write permission to here \$selDataPath. Therefore operator '!' to bail out on hasWriteAccess() returning false. A message will be outputted with echo in hasWriteAccess() - but only if it returns false. This means that it can only be used for bail out with the prefix '!' because otherwise javascript will not receive feedback about incorrect context.  
This is the case with all tests - the individual test must be used either with or without negation - but always the same.
</div>

#### Response functions

API methods return what fits the javascript function that receives the response. It is an argument to the call of the request function, which function should receive the response. It is given, for a specific API method, which javascript function receives a response from that particular API method.

There is  5 response functions - they all starts with the same 3 lines and 3 of them has the same 4. line as in showMenu() here
 
EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function showMenu',4 ),<<<EOMD

API feedback can be divided into two groups.
- the file list is redrawed
- status line notification

APIs returns a string, a JSON encoded array of two strings or, in the case of the file list, a JSON encoded array of arrays.

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function catchResp','^$' ),<<<EOMD
$srcExpl

Parse error occurs when PHP throws one of the fatal errors that cannot be caught in an exception handler. It is then printed in raw format on the status line.
</div>

IsPhpErr, redrawDir and redrawUpperDir is defined on pages that enherents fra class StdMenu

```
 <script>
   const isPHPErr='errOrConf';
   const redrawDir='redrawDir';
   const redrawUpperDir='redrawUpperDir';
```

EOMD,srcf('defines.php','IS_PHP_ERR',1,'CONFIRM_COMMAND',1),<<<EOMD

These 2 constant names with same value is used in PHP to 2 things.

#### Exception
EOMD,srcf('index.php','catch',10),<<<EOMD

HocusPocus has the php.ini settings that enable functions such as copy, mv, chmod, chgrp etc. which is documented at https://www.php.net/ to be able to return false on error, to never return false, but throw an exception.

#### Feedback on performed operation

```
echo json_encode([CONFIRM_COMMAND,'message about it']);
```
For some operations, the status line message is too much noise as the change is immediately reflected in the file list or the status line's file info. Such operations has this as forwarding response function

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function nopJSCommand','^$'),<<<EOMD

And the API can just return this.

```
echo json_encode([REDRAW_DIR,'']);
```

#### \$_GET argumenter

General keys in the \$_GET argument in API methods:
- 'selname'
    - denotes which file is selected in the dialog menu's list. 
- 'txtinput' 
    - the answer, which the prompt, in a command in the dialog menu, has recieved.
- 'curdir'
    - current directory for dirlist in the dialog menu - it starts with pages/ and thus addresses from data/ in webdir and is also path in webdir for pages class.
    
#### About variable names 

\$\_GET keys is used as prefix to variable names the way [PHP extract](https://www.php.net/manual/en/function.extract.php) makes it with EXTR_PREFIX_ALL,'_GET-key_'  

Names [PHP pathinfo](https://www.php.net/manual/en/function.pathinfo.php) uses
- 'basename' is 'filename' dot 'extension'
- in 'dirname', which has no trailing slash, is 'basename' 

Following has relevans
- \$selname_basename
- \$selname_extension
- \$selname_filename
- \$txtinput_basename
- \$txtinput_extension
- \$txtinput_filename
- \$curdir_dirname
- \$curdir_basename

Some way to  create those variables 
```
extract(\$_GET['txtinput'],EXTR_PREFIX_ALL,'txtinput');
\$txtinput_ext = \$txtinput_extension ?? ''
```
$srcExpl

txtinput_extension is missing if \$\_GET['txtinput'] do not have a dot - \$txtinput_ext is created because that spans better over ambiguous algoritms in source code.  
It is used for input verification - it is determined that directories must not contain periods and data file names must have the extension '.md' or '.php'
</div>

#### Composite variable names

```
\$selPath = \$_GET['curdir'].'/'.\$_GET['selname'];
\$selDataPath = 'data/'.\$_GET['curdir'].'/'.\$_GET['selname'];
\$imgSelPath = 'img/'.\$_GET['curdir']."/\$selname_filename";
\$txtinputPath = \$_GET['curdir'].'/'.\$_GET['txtinput'];
\$txtinputDataPath = 'data/'.\$_GET['curdir'].'/'.\$_GET['txtinput'];
```




### toc
- [edit](edit)
- [emptyTrash](emptyTrash)
- [ls](ls)
- [mkDir](mkDir)
- [mv](mv)
- [mvDir](mvDir)
- [newFile](newFile)
- [rm](rm)
- [rmDir](rmDir)
- [saveFile](saveFile)
- [setSessionVar](setSessionVar)
- [undoTrash](undoTrash)


EOMD,actors\tocNavigate($func)];