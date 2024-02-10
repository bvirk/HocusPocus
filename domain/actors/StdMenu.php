<?php
namespace actors;



function hamMenu() {
    global $pe;
    $thisUrl='url=/'.implode('/',$pe);
    [$trashIcon,$trashTitle] = count(scandir('trash')) > 2 
         ? [ '♻',"trash has items"] 
         : ['♲',"trash is empty"];
    [$ahref,$atxt] = isLoggedIn() 
        ? ["/?path=progs/loginRecieve/logout&amp;$thisUrl",$_SESSION[LOGGEDIN]] 
        : ["/?path=progs/html/login&amp;$thisUrl",'login'];
    // IKON SHOWS WHAT CAN Be CHANGED TO - default is file -> cloud
    [$editIkon,$editTip,$onclick ] = $_SESSION['editmode'] == DEFAULTEDITMODE 
    ? ['🌥 ☐','click to edit in browser','toEditMode("http");']
    : ['🌥 ☑','click to edit locally only','toEditMode("file");'];
    ?> <button id="hammenu" onclick="allFuncs.hamDrawMenu();">&#8801;</button>
    <a title='extern dependencies' href='/?path=progs/html/extern&amp;refer=<?=implode('/',$pe)?>'>☕</a>
    <a title='<?= $trashTitle ?>' href='/progs/emptyTrash' ><?= $trashIcon ?></a>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <div>
                <div>
                    <span title="Home page" ><a id='navHome' onClick ='allFuncs.cdhome();'>⌂ </a></span>
                    <span title="One level up"><a id='navBack' onClick='allFuncs.cdback();'> 🔙</a></span>
                </div>
                <div id='curDirStr'></div>
                <ul id='wdFiles'></ul>
                <div id='statusLine'></div> 
                <form onsubmit="allFuncs.submitAll(event)">
                    <label id="txtinputlabel" for="txtinput">unassigned</label>
                    <input id="txtinput" type="text" name="txtinput" value="">
                    <input id="command" type="hidden" name="command">
                    <input id="selname" type="hidden" name="selname" value="">
                </form>
            </div> 
            <div>
                <a href='<?=$ahref?>'><?=$atxt?></a>
                <p>
                    editmode:<br>
                    &nbsp;<a id='editplace' onClick='allFuncs.<?=$onclick?>' title='<?=$editTip?>'><?=$editIkon?></a>
                </p>
            </div>
            <div id='close'>
                <a title="'q' for quit" onClick="allFuncs.close();">╳</a>
            </div>
        </div>
    </div><?php
}

class StdMenu extends PageAware {
    protected $jsFiles= ['/js/jquery.min.js'];

    function stdContent() {
    	hamMenu();
        echo $this->body;
	}
}
