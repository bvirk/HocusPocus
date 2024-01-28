<?php
use function actors\srclf;
return ["<!<div class='auto80'>#html#</div>",actors\tocHeadline($func,1),<<<EOMD
Ved tast 'e' i dialogmenuen gemmes valgte fil:
EOMD,srclf('progs/NNNAPI.php','function edit',1,'file_put_contents\(FILETOEDIT',2),<<<EOMD
Andet element i det array der returneres fanges i det javascript der modtager response
EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js','function savedFiletoeditResponse',1,"== 'http'",2),<<<EOMD
$srcExpl
progs/edit/content åbnes i ny tab i browser
</div>

EOMD,srclf('progs/Edit.php','namespace progs',17),<<<EOMD
$srcExpl

function stdContent() fra class StdMenu outputter html'en til ham menuen - property \$body er tomt, da her er tale om en method.   
Indholdet af fil hvis navn er config/filetoedit.txt tildeles \$content med encoding af &lt; og &gt;  
\$content bliver indhold i contenteditable &lt;div&gt;. Filnavn er også parameter til buttons onclick function.  
</div>

EOMD,srclf('jsmodules/StdMenu/main.js','allFuncs.saveContent',2),<<<EOMD
$srcExpl
Indhold af contenteditable &lt;div&gt; fiskes ud med jquery og postes
</div>

EOMD,srclf('progs/NNNAPI.php','function saveFile',11),<<<EOMD
$srcExpl
Indholdet bygges op fra \$_POST['content']. Et problem med indsatte linieskift er løst ved at indsatte som ↵ (8229) tegn erstattes med linieskift.
</div>

EOMD,srclf('jsmodules/StdMenu/reqCallBacks.js'
    ,'function savedFileResponse',1
    ,"httpRequest.responseText === 'close'",2),<<<EOMD



EOMD,actors\tocNavigate($func)];