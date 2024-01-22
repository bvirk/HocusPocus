<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
The part of a url that comes after the domain is called its path. After all, path is something every file and directory has, so sometimes path will be used instead of the path part of the url.



### Two addressing ways

- [/$classPath/$func](/$classPath/$func)
- [/?path=$classPath/$func](/?path=$classPath/$func)


The first is used to get nice reusable urls in the browser's address line - the last where it must be possible to transfer parameters. The last one is called the query string way and the APIs and source code viewer uses this.  

The nice url path is made with this apache web server rule
```
RewriteRule ^([\w+/]+)$ ?path=\\$1
```
There is the challenge that if the entire path that is requested is a directory, then the query string path will certainly be correct, but the request will be prefixed with this directory - i.e. directed at an index.php which is __not__ located in the document root but in the request path directory - and that's not the idea!

The problem is solved with redirection.  

To make it easy to explore the effect of redirection, index.php has these lines
EOMD,srclf('index.php','Uncomment for inspection','2'),<<<EOMD

Redirection targets the path 'pages' because all web pages in HocusPokus start with 'pages'.

```
...
RewriteRule ^pages$ /pages/da/index [R=302]
RewriteRule ^pages/da$ /pages/da/index [R=302]
RewriteRule ^pages/en$ /pages/da/index [R=302]
RewriteRule ^da$ /pages/da/index [R=302]
RewriteRule ^en$ /pages/en/index [R=302]
RewriteRule ^([\w+/]+)$ ?path=\\$1
...
```
Along with the redirection in index.php's source code, the following lists the cases that __don't__ show Apache's little-appreciated 'page cannot be displayed' or any other url error info.
- the domain only [/](/)
- one of the langage choices [/da](/da) eller [/en](/en)
- [/pages/da](/pages/da) or [/pages/en](/pages/en), because you could think you ought to write so.
- [/pages](/pages)
- [/pages/gibberish](/pages/gibberish)
- [/gibberish](/gibberish) which is not a directory

It has been chosen not to redirect any directory in the document root. Afterall, what is chances of a fail url like [/css](/css)

### Relative links.
Relative links depends on path not ending with a slash
EOMD,srclf('index.php','We dont allow url','3'),<<<EOMD
$srcExpl
Redirection is necessary as it determines how the browser defines relative links.
</div>

### [.htaccess vs. apaches VirtualHost config fil](http://httpd.apache.org/docs/2.4/howto/htaccess.html#when)
The above link argues against using .htaccess. An argument goes to file readings at directory back threading which does not applies here where it is always index.php that is called. However, it always requires an extra .htaccess file reading per request, but if a hosting does not allow access to Apache's config file, it may be necessary to use .htaccess

EOMD,actors\tocNavigate($func)];