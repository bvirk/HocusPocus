<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
HocusPocus has the role of retrieving data. It is the base class for all classes that retrieve content from the data directory  


In method \_\_call(\$func, \$funcArgsArray ), which is called in the absence of an actual method, data is retrieved. It happens in the class that corresponds to the url and that descends from HocusPocus.

### Rendering

EOMD,srclf('HocusPocus.php'
    ,'@param array which last','3',
    'Replaces pattern in last array element','3',
    'abstract class','4',
    '__call','1','include\(\$incPath','24'),<<< EOMD
$srcExpl

What the 'data file' \$incPath returns is an array of strings - \$content. It __can__ be a single string which is then arrayed for uniform looping.  
Two stacks are juggled, the content stack, \$cStack and the tempate stack, \$tStack
</div>

EOMD,srclf('HocusPocus.php','->stdContent','1','abstract function','1'),<<< EOMD
$srcExpl

HocusPocus cannot be self-instantiated.  
Because stdContent() is abstract, it is the implementation in a subclass that uses property \$body
</div>

### Variables for insertion into content
The simplest way to make things styleable is to have variables to be inserted into heredocs.

EOMD,srclf('HocusPocus.php','__call','1','datafileExists','5','function enheritPathElements','12'),<<< EOMD
$srcExpl

Function inheritPathElements return class hierarchy inheritance as array of path elements. It is classes with namespace actors that are included.  
The data file \$incPath source code environment is a mix of partly being in the same variable scope as \_\_call and partly being able to return to \_\_call. Variables declared in \$dataVarsFile, which are included before \$incPath become part of \_\_call's variable scope.
</div>

### \_\_call pitfalls

Typos and erroneous calls of updater methods could quickly end up at __call(...). Two mechanisms seek to trigger an error whose wording draws attention to the source of the error.

EOMD,srclf('HocusPocus.php','__call','9'),<<<EOMD
$srcExpl

1. A function inside a method - you can do this the first time the process runs through - the next triggers a redeclaration error.
2. \$func is the methodname __call substitutes, and it is the last path element of the url.
</div>

### Not existing url
We have seen that index.php handles how far a urls class exists, but it is not guaranteed that the last path element, as designated data, exists.

EOMD,srclf('HocusPocus.php','"data\/\$classPath\/\$func"','3','neither','9','function noDataAvail','6'),<<< EOMD
$srcExpl

dataFileExists(\$incPath) returns true if adding either .md or .php to reference parameter \$incPath becomes the name of an existing file.  
If the file with data does not exist, a differentiation is made between whether it is a page (DEFCONTENT) or progs url. progs always triggers an exception (programmer error), while for pages an exception is also triggered in displayed source - but you can choose between an exception or calling the default page by commenting out.  
The context for the necessity of using javascript for redirection is that pages (DEFCONTENT) all inherit from actors\\PageAware which inherit from HocusPocus. This means that all html including &lt;body&gt; target has been output and the request ends with function __destruct() which sends &lt;/body&gt;&lt;/html&gt;
</div>

### Content type text/plain
Is selected in \_\_constructer() - it is naturally overridden for all pages and programs that may need it. It is to keep focus during testing and inspection when looking at it in the browser - ie __not__ see something through a layer of html rendering performed by the browser.

EOMD,actors\tocNavigate($func)];