<?php 
use utilclasses\Sitemap;
$sitemap = (new Sitemap())->dirlisthtml();
return [
"<!<div class= 'auto80'><div class='centertext'>#html#</div><div class='marginleft170px'>#html#<div></div>"
,
    <<<EOMD
# HOCUSPOCUS
### a php-nnn applause
    
Navigation wih keyboard  

|               |               |
|:--            |:--            |
|F9             |menu           |
|e              |edit file          |
|n              |new fil or dir     |
|r              |rename file or dir |
|q              |quit menu          |
|t              |empty trash        |
|x              |remove file or dir |
|y              |confirm delete     |
|z              |restore all from trash   |
|arrow keys     |navigate around|
|Enter          |select page    |
|Home           |default page   |

![keyboard]($imgPath/keyboard.jpg)
EOMD,">!>",<<<EOMD
#### About    
HocusPocus is a PHP web framework with a Javascript dialog menu inspired by [filemanager nnn](https://github.com/jarun/nnn/wiki).

Css and javascript are associated with pages according to principles of specialization known for class hierarchies.  

The dialog menu supports the creation, renaming and deletion of pages and their directories and editing content in browser.

HocusPocus' counterpart to nnns 'e' for edit selected, is to save the file name in a file on the server, __and__, choiceable, open the file for editing in a new browser tab. This, two ways choice, assists a simple way for minor corrections in browser and more assisted in a real editor. How local edit is made depends on how the server's file system is made accessible.

#### Sitemap
$sitemap
EOMD];
