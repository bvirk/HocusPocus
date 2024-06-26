import { request, httpRequest  } from "../jslib/request.js";
import * as dlg from "./dialog.js";
import * as keyb from "./keyboard.js";

export let curDir;
export let dirPermStat;
export let dirHasDir;

function catchResp() {
    try {
        let resp = JSON.parse(httpRequest.responseText);
        
        if (resp[0] == isPHPErr) { // Used without error too, as confirmation of commands
            if (resp[1].length) 
                simpleStatLine(resp[1]);
            return null;
        }
        if ('phpError' in resp) {
            simpleStatLine(resp.phpError)
            return null;
        }
        return resp;
    } catch(e) {
        if (e.message.startsWith('JSON.parse')) {
            simpleStatLine(httpRequest.responseText);
         } else
            simpleStatLine('perhaps som javascript error');
    }
}

export function nopJSCommand() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let resp = catchResp();
    if (resp == null) return;
    if (resp[0] == redrawDir || resp[0] == redrawUpperDir) {
        if (resp[0] == redrawUpperDir)
            dlg.setCurDirStr(dlg.curDirStr.substring(0,dlg.curDirStr.lastIndexOf('/')));
        request(dlg.APIName,'ls','&curdir='+dlg.curDirStr,showDataDir);
    }
    if (resp[0] == redrawImgDir ) {
        request(dlg.APIName,'lsExt','&selDataPath='+keyb.selDataPath+'&type=img',showExtFiles);
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
    if (fileResp == null) return;
    dlg.statusLine(fileResp[0]+' served'+(dlg.loggedInOwnsSel() ? '':' only'),5000);
    if (fileResp[1] == 'http' && dlg.loggedInOwnsSel())
        window.open('/progs/edit/content','_blank');
}

export let setCurDir = val => curDir=val

export function showDataDir() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let dir=catchResp();
    if (dir == null) return;
    [dirHasDir,dirPermStat,curDir] = dir;
    dlg.drawDirList(curDir);
}

export function showExtFiles() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    curDir = catchResp();
    if (curDir == null) return;
    dlg.drawExtFilesList(curDir);
}

export function importHelp() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let content = catchResp()[1];
    $('#dialog-help').html(content);
}

function simpleStatLine(mes) {
    $("#statusLine").css('display','block').html(mes);
} 