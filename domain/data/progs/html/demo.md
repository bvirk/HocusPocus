<?php
function expln($arg) {
    return var_export($arg,true)."\n";
}
$peStr = expln($pe);
//$srcExplPlain = str_replace(['<','>'],['&lt;','&gt;'],$srcExpl);
$qs = actors\queryString();
return ["<!<div class='top'>\n#html#\n</div>\n<div class='bottom'>\n#html#\n</div>",
    <<< EOTMD
### $func of type $pe[0]
All local variables in \_\_call(...) of \\HocusPocus->\_\_call() is accessible here.

|var          |value            |
|:--          |:--              |
|\$classPath  |$classPath       |
|\$func       |$func            |
|\$imgPath    |$imgPath         |
|\$incPath    |$incPath         |
|\$dataVarsFile    |$dataVarsFile    |
\$pe=$peStr  
query string=$qs
>!>
EOTMD,<<< EOTMD
### About rendering
Because each HERE doc has it's own div, markdown can be styled seperately
EOTMD,srclf('data/progs/html/demo.md',1),<<<EOTMD
### The css
EOTMD,srclf('css/html/demo.css',1)];
