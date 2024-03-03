import * as dlg from "./dialog.js";
import * as keyb from "./keyboard.js";
import { postString } from "../jslib/request.js";
import { submitAll } from "./formsubmit.js";
import * as rsp from "./reqCallBacks.js";
let dlgHtml = `
<div id="dialog-help" data-type="unref" class="dialog-help">XYZ</div>
<div id="modal-content" class="modal-content">
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
        <a href='${ahref}'>${atxt}</a>
        <p>
            editmode:<br>
            &nbsp;<a id='editplace' onClick='allFuncs.${onclick}' title='${editTip}'>${editIkon}</a>
        </p>
    </div>
    <div id='close'>
        <a title="'q' for quit" onClick="allFuncs.close();">╳</a>
    </div>
</div>
`;

$(function() {
    $('#myModal').html(dlgHtml);
    allFuncs.saveContent = function(filetoedit) {
        postString(dlg.APIName,'saveFile',filetoedit,$("#contentdiv").text(),rsp.savedFileResponse);
    }
    keyb.setCurkeyhandler(keyb.KeyHandler.NOMENU);
    allFuncs.hamDrawMenu = dlg.hamDrawMenu;
    allFuncs.submitAll = submitAll;
    allFuncs.cdtonum = dlg.cdtonum;
    allFuncs.cdback = dlg.cdback;
    allFuncs.cdhome = dlg.cdhome;
    allFuncs.close = dlg.quitMenu;
    allFuncs.toEditMode = dlg.toEditMode;
        let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
    if ( dialogState == 'on' && location.pathname != '/progs/edit/content') 
        allFuncs.hamDrawMenu();
});
