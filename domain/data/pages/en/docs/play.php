<?php
use function actors\srclf;
use function actors\srcf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
### Method vs data file
The following works in an installed HocusPocus system. The point is not that the link examples work, but why.

EOMD,srcf('progs/Play.php',1),<<<EOMD

_Example with method_ [/progs/play/myMethod](/progs/play/myMethod)

Url with rewrite does not support parameter transfer - if you want that you have to resort to a traditional query string

_Example with method and query string_ [/?path=progs/play/myMethod&name=doug](/?path=progs/play/myMethod&name=doug)



EOMD,srcf('data/progs/play/index.md',1),<<<EOMD

_Example with data file_ [/progs/play/index](/progs/play/index)

_Example with method and query string_ [/?path=progs/play/index&name=doug](/?path=progs/play/index&name=doug)

### A more complex example


EOMD,srclf('data/progs/play/demo.md',1),<<<EOMD

_Plain tekst Example_ [/progs/play/demo](/progs/play/demo)  
_Html Example_ [/progs/html/demo](/progs/html/demo)


##### progs\\Play is not a html document
progs\\Play inherits only from HocusPocus - no html head and other stuff is created and in order for this to be viewed in browser, a header with Content-type: text/plain is sent.  

##### Ways of writting the returned data
It's an array of strings that is returned by  the data file.  
PHP heredocs section is mostly the way to write what is returned, but the purpose of returning an array of strings allows for different expressions.
function srclf() is an example of using functions that return a string. It is used to return __s__ ou __r__ __c__ e with __l__ ini number and initial __f__ ilname.

##### Define things before return statement 
Heredocs supports interpolation of variables and array values indexed with numbers. Therefore, it can be convenient to create variables before the return statement. Content-wise dollar must be preceded by a backslash in heredocs.  
You can also create functions before return - it is used here to see the \$pe array.  
What appears in data/progs/play/demo.md are variables that are accessible because they are defined inside the HocusPocus->\_\_call method. 

##### Template
Notice &lt;div class='top'&gt; og &lt;div class='bottom'&gt;   
In order to style individual html snippets from the markdown conversion, they can be encapsulated in other html. Templates are array elements that start with '<!<' and contain one or more ![html]($imgPath/html.jpg) strings.

It is a characteristic that you don't have to keep track of the number of array elements - and therefore end elements are used that mark the end of a list which must replace the #html# string in the template. The termination string is '>!>' and an element that  finishes with that makes the termination of a list.

```
return [ "<!<div class='all'><div class='afsnit'>#ht?ml#"</div><div class='slut'>#ht?ml#</div></div>"
, <<<EOTD
afsnit1
EOTD, <<<EOTD
afsnit2
>!>
EOTD, <<<EOTD
afslutning
EOTD];
```
$srcExpl
Because &gt;!&gt; must be the end of the string, EOTD,&lt;&lt;&lt;EOTD on the line below is required. You could also write it in one line as EOTD,"&gt;!&gt;",&lt;&lt;&lt;EOTD. That sections 1 and 2 are made into 2 elements is shown here to emphasize that elements are collected in a list.<br>The string '#ht?ml#' in the example above must be read as it may only be written in templates, as being without '?' between t and m.
</div>

In some situations, it is too difficult with template and termination. You can also write the following which works without going through rendering. Html is legal markdown.

```
...
<div class='things_which_is_styled'>  
My section
</div>
...
```
Since it is often the same class attribute that is used, a mechanism exists to assign variables.
EOMD,srcf($dataVarsFile,1),<<<EOMD

```
..
\$srcExpl  
My section
</div>
..
```
$srcExpl
In that way this green note got a solid green double line left border
</div>


If you want the contents in &lt;div&gt; markdown converted, you can create an empty line after \$srcExpl or use the following which is rendered.

```
...
EOTD,"<!".\$srcExpl.'#ht?ml#</div>',<<<EOTD
My section
>!>
EOTD,<<<EOTD
...
```
$srcExpl
And again, read without '?' between t and m in #ht?ml#
</div>

It is not necessary to list terminate at the end of the data file.
EOMD,actors\tocNavigate($func)];