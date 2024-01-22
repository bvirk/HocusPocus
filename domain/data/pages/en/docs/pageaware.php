<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<< EOMD
All pages whose url starts with '/pages' are handled by a class that inherits indirectly from actors\\PageAware.  

The class that is instantiated by a request is empty because it only satisfies having a namespace that matches the path of the url.  
It inherits from a class that inherits from PageAware - in other words - there is at least one class in the hierarchy that lies between Pageware and the request's instantiating class.  

In PageAware, the entire html document is created, but property \$body is not sendt to output. PageAware's role is to create tags that include css and javascript - as a function of the url's path and the inherit hierarchy as a subclass PageAware.  

PageAware is also abstract because it do not implements stdContent(). It is chosen to enforce descriptive class name(s) for layout types.

EOMD,srclf('actors/PageAware.php','namespace pages','5'),<<< EOMD

I PageAware laves hele html document.

EOMD,srclf('actors/PageAware.php','jsFiles = \[\]','4','__construct','15','function stdContent','3'),<<<EOMD
$srcExpl

The Html document is created in function \_\_construct()  and closed in  \_\_destruct(). it just lacks a function stdContent that outputs the content of the body element - which an inheriting class must define.  

Method getExtern ensures the inclusion of css and javascript, in the following grouping
1. coincidence between url and file and directory names in directories css/ and js/
2. coincidence between class hierarchy path of file and directory names in directories css/ and js/
3. .css .js files property arrays \$cssFiles og \$jsFiles.  

When properties are protected, getExterns() can create tags depending on what inherited classes define
</div>

There is more about how getExterns() works in a later chapter.
EOMD,actors\tocNavigate($func)];