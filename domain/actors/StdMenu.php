<?php
namespace actors;



function hamMenu() {
    global $pe;
    $thisUrl='url=/'.implode('/',$pe);
    [$ahref,$atxt] = isLoggedIn() 
        ? ["/?path=progs/loginRecieve/logout&amp;$thisUrl",'logout '.$_SESSION['loggedin'] != USERS[0] ? $_SESSION['loggedin']:''] 
        : ["/?path=progs/html/login&$thisUrl",'login'];
    // IKON SHOWS WHAT CAN Be CHANGED TO - default is file -> cloud
    [$editIkon,$editTip,$onclick ] = $_SESSION['editmode'] == DEFAULTEDITMODE 
    ? ['🌥 ☐','click to edit in browser','toEditMode("http");']
    : ['🌥 ☑','click to edit locally only','toEditMode("file");'];
    ?> <button id="hammenu" onclick="allFuncs.hamDrawMenu();">&#8801;</button>
    <a title='extern dependencies' href='/?path=progs/html/extern&amp;refer=<?=implode('/',$pe)?>'>☕</a>
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
                    <input id="txtinput" type="text" name="txtinput">
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
    
    
    //public function __construct() {
    //    //if (array_key_exists('prettyprint',$_GET))
    //    //    headerCTText();
    //    ob_start(array_key_exists('pretty',$_GET) ? [$this,'tidyHTML'] : null);
    //    parent::__construct();
    //}
    //
    //public function __destruct()
    //{
    //    echo "\n<!-- ". (__NAMESPACE__.'\snup')() ."  -->\n";
    //    parent::__destruct();
    //    ob_flush();
    //}
    function stdContent() {
    	hamMenu();
        //echo array_key_exists('prettyprint',$_GET) ? tidyHTML($this->body): $this->body;
        echo $this->body;
	}
}
