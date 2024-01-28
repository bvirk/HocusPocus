<?php
use function actors\srclf;
use function actors\srcf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD

Global variable \$pe is \$_GET["path"] in another way.
EOMD,srcf('index.php','pe = explode',1,'used for 2 path element',2),<<<EOMD
The arrayet \$pe is an abbrevation for  __path elements__. There is only a lower limit to the number of elements - it is three, with the exception that if the above allocation gives two then 'index' is added as the third element.

The contents of the \$pe array, illustrated as the path element strings they represent:
```
\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]/\$pe[n-1]
```
#### \$pe[0] 
\$pe[0] is either 'pages' or 'progs'. 'pages' and 'progs' are two directories in document_root.

##### about 'pages'
All requests that display a page in the browser are in 'pages'. A constant, DEFCONTENT, has the value 'pages'. 

##### about 'progs'
'progs' is for API and other things, actually also a bit that appears in the browser but in terms of content not categorized as the type of information the website tells about. Also temporary thing that later gets a real page appearance  
&nbsp;  
&nbsp;  
#### \$pe[0]/\$pe[1]/\$pe[2]/.../.ucfirst(\$pe[n-2].'.php'
Addresses the class that processes the creation of one of several html pages.  
&nbsp;  
&nbsp;  
#### data/\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]
Addresses the directory where data files for the pages of a class resides. data files is used as default mechanism in the absence of explicitly implemented methods of a pages class. It is the the body element that is buildt by the content of a data file.  
&nbsp;  
&nbsp;  
#### data/\$pe[0]/\$pe[1]/\$pe[2]/.../\$pe[n-2]/\$pe[n-1] 
Path to data file without extension. Data files has the extension .md or .php (free choice between syntax highlighting in the editor)  
&nbsp;  
&nbsp;  
#### \$pe[n-1]
\$pe[n-1] is either method or data file. 
&nbsp;  
&nbsp;  
#### \$pe[1] when \$pe[0] == 'pages' 
\$pe[1] can assume one of the values that is key in the following constant - and the first is used as default.
EOMD,srcf('defines.php','LANGUAGES',1),<<<EOMD
&nbsp;  
&nbsp;  
### No 404 narrative 

Instead of a page with a story about a response code, the default page is used.

A request's addressing is one of following three cases. 

1. call with existing address
2. call with domain only - 'path' is __not__ key i \$_GET
3. call with address that don't has any associated class

##### relating to 2
EOMD,srclf('index.php','domain only',2),<<< EOMD

##### relating to 3
Inclusion of the file of a class happens at usual php manners - very short:
EOMD,srclf('index.php',11,3),<<< EOMD

Instantiation happens in a try catch block

EOMD,srclf('index.php','second to last element',16),<<< EOMD

A request is performed by instantiation of a class.  
Because it is in a try catch block, calling a non-existent class will throw an exception in the require_once php function on line 12 in index.php - i.e. inside spl_autoload_register.
In the catch part, it causes conditional relocation to the default url.

What is not captured here in index.php is whether a method or data file, i.e. \$pe[n-1] exists. It is captured in the base class for everything that outputs by fetching data - class \HocucPocus

EOMD ,actors\tocNavigate($func)];
