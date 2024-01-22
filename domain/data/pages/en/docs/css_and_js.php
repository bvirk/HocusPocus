<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
The purpose of this small framework to keep track of css and javascript files. It is the categorization of individual pages dependencies on subsets of css and javascript that must be supported systemically

Several mechanisms are at play
1. property arrays \$jsFiles and \$cssFiles
2. The url
3. class hierarchy

section 1

- Tags that includes the specified files or CDN references are made.


section 2 and 3

- Tags are created to retrieve the union of the files that exist and matches
- Coffee cup icon in the upper left on StdMenu pages shows possible and current files 


### method getExterns() in PageAware

##### External libraries
External libraries are things you don't develop yourself - things like jquery and google fonts.

property \$cssFiles and \$jsFiles can be local files or CDN links. Files links starts with /css/ or /js/ for stylesheets and javascript respectively.

EOMD,srclf('actors/PageAware.php','jsFiles = \[\]','2','function getExterns','1','cssFiles as','4'),<<<EOMD
$srcExpl
It looks nicest that \$cssFiles and \$jsFiles are empty here, because content is intended for actor classes that are not further inherited.
</div>

##### Class hierarchy indexed css and javascript files
What you achieve by specializing in class definitions is also achieved in another way, but still following the class hierarchy.  
js and css files are located in the same directory structure as the class hierarchy - still under css/ and js/.

Since all html documents inherit from actors\\PageAware the following, if they exist, becomes common stuff
- css/PageAware.css
- js/PageAware.js or js/PageAware.php

If there is no file with the extension .js in the hierarchy, a matching file named with the extension .php is looked for
EOMD,srclf('HocusPocus.php','function enheritPathElements','12'),<<<EOMD
$srcExpl

When class_parents(\$this) is reversed HocusPocus comes first.  

(be aware it's a pages class which enherits from an actors class which enherits from actors\PageAware that is \$this)  

The foreach loop build ups up a path of path elements with class names stripped their namespace.  

Because HocusPocus has no namespace it does not became part of the path. Because it is parents we deals with the instantiated pages class is not among.  

The class hierarchy path is like \$pe's counter part, that why \$e_pe for 'enherittance_pe' 
</div>

##### Url indexed css and javascript files

These are in two groups
1. all of which can represent multiple pages.
2. those that only apply to a specific page.

About an url with n path elements  
```
\$pe[0]/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1]  
```
$srcExpl

'pages', \$pe[0] is not included in the indexing with respect to css an javascript
</div>

##### section 1  

The total number of files that may exist  
```
css/\$pe[1].css  
css/\$pe[1]/\$pe[2].css  
css/\$pe[1]/\$pe[2]/\$pe[3].css  
...
css/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2].css  

js/\$pe[1].js eller .php  
js/\$pe[1]/\$pe[2].css eller php 
js/\$pe[1]/\$pe[2]/\$pe[3].css eller php 
...
js/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2].css eller php  
```
$srcExpl

Looping from n=1 to n-2 is like fetching to put behind string from array_slice(\$pe,1,-1)
</div>

##### section 2
```
css/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1].css
js/\$pe[1]/\$pe[2]/\$pe[3]/...\$pe[n-2]/\$pe[n-1].js eller php
```

##### uniform processing of hierarki and url


EOMD,srclf(
    'actors/PageAware.php'
    ,'function getExterns','5'
    ,"'src','js'",'1'
    ,'function incFiles','12')
        ,<<<EOMD
$srcExpl
In the innermost forEach, extRef(...) is called with the current directory string extension which applies to what is above called group 1 and after the forEach group 2. Parameters for extRef are what is needed to create html tags and attributes.
EOMD,'>!>',<<<EOMD

EOMD,srclf('actors/PageAware.php','function extRef','7'),<<<EOMD
$srcExpl
In extRef, it is checked whether a non-existing .js file is instead a .php file, which is then included. lastmRef appends ?lastm= (unixtime) to the src or href attribute value.
</div>

EOMD,srclf('actors/Pagefuncs.php','function lastmRef','3'),<<<EOMD

We have now seen that HocusPocus takes care of retrieving data and actors\\PageAware uses that data to create an html document with all its tags to retrieve css and js files.  

Making PageAware a specialization for use as html document makes it possible to retrieve data only where html is not needed - as in APIs that return json.  


It is not intended to use PageAware directly, because then you lock yourself out of doing something other than what you specialize PageAware for.  

You have to inherit, as in the StdMenu that layouts these words. Before the chapter about StdMenu, something about the dialog menu  
EOMD,actors\tocNavigate($func)];