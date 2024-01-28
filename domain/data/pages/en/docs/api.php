<?php
$domain=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
use function actors\srclf;
use function actors\srcf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
#### Demo without API

[Fortunes uden api](/progs/html/fortunes) excels at lyricism by displaying a new colored word of wisdom for each click of a button.  

EOMD,srclf('progs/Html.php','namespace'),<<<EOMD
$srcExpl
Class Html includes the possibility to express oneself in jquery
</div>

prog/html/fortunes data file layouts the html

EOMD,srclf('data/progs/html/fortunes.md',1),<<<EOMD
Javascript makes it work. As previously shown, when the url is progs/html/fortunes, php makes potentially a html tag including a file with path:

EOMD,srclf('js/html/fortunes.js',1,4,'patch'),<<<EOMD

You can say that the javascript generated style and html content has data in it.

#### With API

With API, data is retrieved via a request.  

It is the php part of the API application that is displayed in this chapter - i.e. the service that responds.

enjoy the lyrics [fortunes API](/progs/fortunesAPI/fortune) - or in terminal

```
$ curl -k $domain/progs/fortunesAPI/fortune && echo
```

EOMD,srclf('progs/FortunesAPI.php','namespace',11,'patch a bug',7),<<<EOMD
$srcExpl
It is echo that is 'return value' in an API call - and json_encode of an array is used.
</div>

#### Catching errors in PHP source code from javascript

Appreciate [fortunes API with php error](/?path=progs/fortunesAPI/fortune&mkErr) or in terminal
```
$ curl -k "$domain/?path=progs/fortunesAPI/fortune&mkErr" && echo

["<isPHPErr>","PHP ERROR in ...\/globalfuncs.php:26"]
```
The cause of PHP error is saved in config/filetoedit.txt. With terminal i lokal webdir's document_root
```
$ cat config/filetoedit.txt

include(idontexists):_Failed_to_open_stream:_No_such_file_or_directory /var/www/vps/domain/progs/FortunesAPI.php:28
```
The content of config/filetoedit.txt is there to be used for automatically opening the error infected file in an editor at the infamous line. A tool for this is e.g. [wed](https://raw.githubusercontent.com/bvirk/localebin/main/wed)

#### PHP error reporting way, that can be accessed from javascript

EOMD,srclf('progs/FortunesAPI.php','__construct',2),<<<EOMD


EOMD,srclf('globalfuncs.php','headerCTText',9),<<<EOMD
$srcExpl
plain text in browser and seting global variabel \$usesJSON to true.
</div>


EOMD,srclf('index.php',"pe=\[\];",8,'try'),<<<EOMD
$srcExpl
We are in index.php where requests are executed as method calls on the instantiated class. Exceptions end in catch and the error's message, file name and line number are written to file.
The request ends with echo of a json encoded array whose first string is a set pattern for errors.
</div>

Javascript that receives from API call, handles the error response with knowledge of what IS_PHP_ERR is.  

Not all PHP errors return to exception catch block - fatal errors simply throw an error message as a text response and exits all futher execution. javascript json parse error can be used in source code as signal for that that has happened.

#### Common pages as API

Note function instantiatePath() above. Because it is the top level function that processes the request, it is natural to wonder when thinking about simply showing a page.

It's a hook to do like apache does with the whole index.php - here is an application:

Sometimes, especially when developing in php, it can be informative to orientate yourself in the html source. Html head and the hammenu are reasonably nice - but the body element is messy.

Try comparing the source code here with [this presentation](/?path=progs/mkPage&redir=$classPath/$func) - optimistically a minor difference can be seen.

EOMD,srcf('progs/MkPage.php',1,'DOMDocument'),actors\tocNavigate($func)];
