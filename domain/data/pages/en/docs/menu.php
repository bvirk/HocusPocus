<?php
return ["<!<div class='auto80'>#html#</div>"
,actors\tocHeadline($func),
    <<<EOMD
HocusPocus has had many less magical predecessors and is shaped by ideas that have suddenly discarded older ways.

It was also not clear what this small php framework was to be used for - was it not more like a document management system based on markdown documents.
    
Ideas abound on the web - also for Linux users. Filemanager [nnn](https://github.com/jarun/nnn/wiki) replaced traditionally used [Midnight Commander](https://en.wikipedia.org/wiki/Midnight_Commander)
    
The menu is the modal dialogue that pops up when the hamburger in the upper right corner is activated.
    
You can create, delete, rename and edit files and folders - the menu makes HokusPocus a CMS.
    
The menu appears more like an administration thing than something you find your way around on a web page. You can then consider its basis as something that is reused in the design of another menu.
    
The technique is javascript and [AJAX](https://en.wikipedia.org/wiki/Ajax_(programming)#References) and as much wannabe nnn functionality that gets the job done.

Tabs and making do not exist - if you want to move a file, you have to create a new one, move the content and delete the original one.

Certain things the dialog menu can do that nnn cannot; it can synchronize the renaming of directories with the necessary changes in HocusPocus namespaces for classes.
    
Next chapter is about the class that implements the dialog menu's html skeleton and loads the javascript.
EOMD,actors\tocNavigate($func)];