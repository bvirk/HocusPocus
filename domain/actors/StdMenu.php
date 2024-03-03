<?php
namespace actors;

function dialogTopDiv() {
    global $pe; ?>
    <button id="hammenu" onclick="allFuncs.hamDrawMenu();">&#8801;</button><a title='prettify html' href='/?path=progs/mkPage&amp;redir=<?=implode('/',$pe)?>'>🦋</a><div id="myModal" class="modal"></div>
<?php }

class StdMenu extends PageAware {
    protected $jsFiles= ['/js/jquery.min.js'];

    function stdContent() {
    	dialogTopDiv();
        echo $this->body;
	}
}
