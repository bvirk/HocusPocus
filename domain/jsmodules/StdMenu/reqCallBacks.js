
import { request, httpRequest  } from "../jslib/request.js";
import { statusLine, initDomElements, APIName } from "./hamMenu.js";

export let curDir;

function catchResp() {
    try {
        let resp = JSON.parse(httpRequest.responseText);
        
        if (resp[0] == isPHPErr) { // Used without error too, as confirmation of commands
            statusLine(resp[1]);
            console.log('resp[0] == isPHPErr: '+resp[0]+','+resp[1])
        }
        return resp;
    } catch(e) {
        if (e.message.startsWith('JSON.parse')) {
            statusLine(httpRequest.responseText);
            console.log(httpRequest.responseText)
         } else
            statusLine('perhaps som javascript error');
    }
}

export function nopJSCommand() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let resp = catchResp();
    if (resp[0] == redrawDir || resp[0] == redrawUpperDir) {
        if (resp[0] == redrawUpperDir)
            curDirStr=curDirStr.substring(0,curDirStr.lastIndexOf('/'))
        request(APIName,'ls','&curdir='+curDirStr,showMenu);
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
    let editIkon='🌥 ☑';
    let editTip='click to edit locally only'
    let clickfunc='allFuncs.toEditMode("file");'
    if (httpRequest.responseText=='file') {
        editIkon='🌥 ☐';
        editTip='click to edit in browser';
        clickfunc='allFuncs.toEditMode("http");'
    }
    $('#editplace').attr('title',editTip).attr('onClick',clickfunc).text(editIkon);
}

export function savedFiletoeditResponse() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    let fileResp = catchResp();
    statusLine(fileResp[0]+' served',5000);
    if (fileResp[1] == 'http' && isLoggedin)
        window.open('/progs/edit/content','_blank');
}

export function showMenu() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    curDir = catchResp();
    let backVisibility = curDirStr.length > 5 ? 'inline' : 'none';
    $('#navBack').css('display',backVisibility); 
    $('#wdFiles').empty();

    for (const index in curDir) {
        let look=curDir[index][0]+(curDir[index][1]);
        let href='/'+curDirStr+'/'+look+(curDir[index][1].length ? 'index':'');
        if (!curDir[index][1].length) 
            href = href.substring(0,href.lastIndexOf('.'));
        let clknav =  curDir[index][1].length 
            ? "<span class='clicknav' onclick='allFuncs.cdtonum("+index+");'>📁</span>&nbsp;&nbsp;"
            : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $("#wdFiles").append("<li>"
            +clknav+"<a href='" 
            + href 
            +"' id='pid"+(index)
            +"' class='"
            + (curDir[index][1].length ? "selIsDir":"selIsFile")
            +"'>"+look
            +"</a></li>");
    }
    $("#curDirStr").text(curDirStr);
    initDomElements();
}
