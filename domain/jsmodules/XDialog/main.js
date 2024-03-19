import * as dlg from "./dialog.js";
//import * as keyb from "./keyboard.js";
//import { postString } from "../jslib/request.js";
//import { submitAll } from "./formsubmit.js";
//import * as rsp from "./reqCallBacks.js";
let dlgHtml = `
<script>var allFuncs={};</script>
<button id='openDialog' onClick='allFuncs.hamToggleMenu(true);'>☰</button>
<div id="dlgBG">
    <div id="dialog">
        <button id='closeDialog' onClick='allFuncs.hamToggleMenu(false);'>✕</button>\n
        <br>xxxxxxxxxxx
    </div>
</div>
`;
$(function() {
    $('#root').html(dlgHtml);
    //allFuncs.saveContent = function(filetoedit) {
    //    postString(dlg.APIName,'saveFile',filetoedit,$("#contentdiv").text(),rsp.savedFileResponse);
    //}
    //keyb.setCurkeyhandler(keyb.KeyHandler.NOMENU);
    allFuncs.hamToggleMenu = dlg.hamToggleMenu;
    //allFuncs.submitAll = submitAll;
    //allFuncs.cdtonum = dlg.cdtonum;
    //allFuncs.cdback = dlg.cdback;
    //allFuncs.cdhome = dlg.cdhome;
    //allFuncs.close = dlg.quitMenu;
    //allFuncs.toEditMode = dlg.toEditMode;
    //    let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
    //if ( dialogState == 'on' && location.pathname != '/progs/edit/content') 
    //    allFuncs.hamDrawMenu();
});
