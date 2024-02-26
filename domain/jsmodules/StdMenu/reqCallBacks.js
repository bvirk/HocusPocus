import { request, httpRequest  } from "../jslib/request.js";
import * as dlg from "./dialog.js";

export let curDir;
export let dirPermStat;

function catchResp() {
    try {
        let resp = JSON.parse(httpRequest.responseText);
        
        if (resp[0] == isPHPErr) { // Used without error too, as confirmation of commands
            if (resp[1].length)
                dlg.statusLine(resp[1]);
        }
        return resp;
    } catch(e) {
        if (e.message.startsWith('JSON.parse')) {
            dlg.statusLine(httpRequest.responseText);
         } else
            dlg.statusLine('perhaps som javascript error');
    }
}

export function nopJSCommand() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let resp = catchResp();
    if (resp[0] == redrawDir || resp[0] == redrawUpperDir) {
        if (resp[0] == redrawUpperDir)
            dlg.setCurDirStr(dlg.curDirStr.substring(0,dlg.curDirStr.lastIndexOf('/')));
        request(dlg.APIName,'ls','&curdir='+dlg.curDirStr,showDataDir);
    }    
}

export function savedFileResponse() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
    return;
    if (httpRequest.responseText === 'close')
        window.close();
    else {
        let str=httpRequest.responseText;
        alert(str+"("+str.length+")\n"+convertToHex(str));
    }
}

export function setEditMode() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let [editIkon,editTip,clickfunc] = catchResp()[1]=='file' 
        ? ['🌥 ☐','click to edit in browser','allFuncs.toEditMode("http");']
        : ['🌥 ☑','click to edit locally only','allFuncs.toEditMode("file");']; 
    $('#editplace').attr('title',editTip).attr('onClick',clickfunc).text(editIkon);
}

export function savedFiletoeditResponse() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let fileResp = catchResp();
    dlg.statusLine(fileResp[0]+' served'+(dlg.ownsSel() ? '':' only'),5000);
    if (fileResp[1] == 'http' && dlg.loggedInOwnsSel())
        window.open('/progs/edit/content','_blank');
}

export let setCurDir = val => curDir=val

export function showDataDir() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    [dirPermStat,curDir] = catchResp();
    dlg.drawDirList(curDir);
}

export function showExtFiles() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    curDir = catchResp();
    dlg.drawExtFilesList(curDir);
}

export function importHelp() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let content = catchResp()[1];
    $('#dialog-help').html(content);
}
