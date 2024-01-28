<?php
use function actors\srclf; 
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
By pressing 'e' in the dialog menu, the selected file is saved:
EOMD,srclf('progs/NNNAPI.php','function edit',1,'file_put_contents\(FILETOEDIT',2),<<<EOMD
Second element in the array that is returned, is captured in the javascript that receives the response
EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function savedFiletoeditResponse',1,"== 'http'",2),<<<EOMD
$srcExpl
progs/edit/content opens in a new browser tab
</div>

EOMD,srclf('progs/Edit.php','namespace progs',17),<<<EOMD
$srcExpl

function stdContent() defined in class StdMenu outputs the html for the hammenu - property \$body is empty, as this is a method.
The content of file whose name is config/filetoedit.txt is assigned to \$content with encoding of &lt; and &gt;
\$content becomes content in contenteditable &lt;div&gt;. Filename is also parameter for button's onclick function.
</div>

EOMD,srclf('jsmodules/StdMenu/main.js','allFuncs.saveContent',2),<<<EOMD
$srcExpl
Content of contenteditable &lt;div&gt; fished out with jquery and posted
</div>

EOMD,srclf('progs/NNNAPI.php','function saveFile',11),<<<EOMD
$srcExpl
The content is built from \$_POST['content']. A problem with inserted line breaks is solved with ↵ (8229) characters replaced with line breaks.
</div>

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js'
    ,'function savedFileResponse',1
    ,"httpRequest.responseText === 'close'",2),actors\tocNavigate($func)];