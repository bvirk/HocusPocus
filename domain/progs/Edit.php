<?php

namespace progs;

class Edit extends \actors\StdMenu {
    
    function content() {
        $this->stdContent();
        $filetoedit = explode(' ',file_get_contents(FILETOEDIT))[1];
        $content = str_replace(['<','>',],['&lt;','&gt;'],file_get_contents($filetoedit));
        ?>
    <div class='auto80'>
        <p>file: <?= $filetoedit ?></p>
        <div contenteditable='true' autocomplete='off' autocorrect='off' autocapitalize='off' spellcheck='false' id='contentdiv'><?=$content?></div>
        <button onclick="allFuncs.saveContent('<?=$filetoedit?>');">Save</button>
    </div>
    <?php }
}