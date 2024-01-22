<?php
return ["<!<div class='auto80'>#html#</div>",<<<EOMD
## NNNAPI

[nnn](https://github.com/jarun/nnn/wiki) is a text-based linux file manager that is keyboard operated and has some intuitive keys for common file operations.  
One of its characteristics is that it is menuless and therefore easy, GUI-wise, to imitate as a dialog menu in a browser.  

The dialog menu is javascript based and serviced by NNNAPI in php.  

It is the data/pages directory tree that the dialog menu can pan around in, but file operations are complex and involve css/, js/, pages/ and img/pages as well. File operations such as create, rename and delete can include several files and/or their contents - things that would be tedious and easy to do wrong manually are thus ensured to be done consistently.  

To return is used in the following about echo in the PHP API source code - because it is, seen from the javascript function that handles the response, a return from the  API call.

API methods return what fits the javascript function that receives the response. It is an argument to the call of the request function, which function should receive the response. It is given, for a specific API method, which javascript function receives a response from that particular API method.

A string or a json encoded array of strings is a common response, where the first element in the array has a signal value of whether the command was successful or not. It is the value IS_PHP_ERR that acts as a flag. In javascript array index and character index is written in the same way - that is used to conclude broadly on index 0 of the response.

General keys in the \$_GET argument in API methods:
- 'selname'
    - denotes which file is selected in the dialog menu's list. 
- 'txtinput' 
    - the answer, which the prompt, in a command in the dialog menu, has recieved.
- 'curdir'
    - current directory for dirlist in the dialog menu - it starts with pages/ and thus addresses from data/ in webdir and is also path in webdir for pages class.
    

About variable names
- Postfix WOE i variable name for 'without extension'.

url encoding
- '|' is an encoding of '.' i url.





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