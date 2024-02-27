import { request }    from "../jslib/request.js";
import * as rsp from "./reqCallBacks.js";
import * as keyb  from "./keyboard.js";
import * as frm from "./formsubmit.js";

export const APIName='/?path=progs/NNNAPI';
export let cid;
export let curDirStr;
let isFirstDraw;
let lid;
export let permStatSel;

export function arrowDown(length) {
    lidNormal();
    cid += cid < length-1 ? 1 : 1-length;
    permStatSel=rsp.curDir[cid][4];
    lidInverse();
    lid[cid].focus();
    statusLine();
}

export function arrowUp(length) {
    lidNormal();
    cid -= cid ? 1 : 1-length;
    lid[cid].focus();
    permStatSel=rsp.curDir[cid][4];
    lidInverse();
    statusLine();
}


export let cdback = () => {
    if (curDirStr.length > /* 'pages' */ 5) { 
        let rpos=curDirStr.lastIndexOf('/');
        curDirStr = curDirStr.substring(0,rpos);
        $("#wdFiles").empty();
        request(APIName,'ls','&curdir='+curDirStr,rsp.showDataDir);
    }
}

export let cdhome = () => {
    curDirStr = 'pages';
    $("#wdFiles").empty();
    request(APIName,'ls','&curdir='+curDirStr,rsp.showDataDir);
}

export function cdtonum(num) {
    curDirStr += '/'+rsp.curDir[num][0]
    //console.log(curDirStr);
    request(APIName,'ls','&curdir='+curDirStr,rsp.showDataDir);
}

export let drawRefTypes = () => {
    rsp.setCurDir( [
         ['css'," css-files",'css files','',permStatSel]
        ,['js'," js-files",'js files','',permStatSel]
        ,['img'," image-files",'javascript files','',permStatSel]
    ]);
    drawDirList(rsp.curDir);
}
export function drawExtFilesList(dirList) {
    //alert(dirList);
    //return;
    $('#navBack').css('display','inline'); 
    $('#wdFiles').empty();
    for (const index in dirList) {
        let look=dirList[index][0];
        let href =  dirList[index][1] == 'e' 
            ? '/?path=progs/html/source&file='+dirList[index][0]
            : (dirList[index][1] == 'i'
                ? '/'+dirList[index][0]
                : '#');
        let [itemHead,itemTail] = ["<a href='" + href + "' ","</a>"];
        $("#wdFiles").append("<li>"
            +itemHead
            +"id='pid"+(index)
            +"' class='"+ dirList[index][1] + dirList[index][3]
            +"'>"+look+itemTail
            +"</li>");
    }
    $("#curDirStr").text(keyb.selDataPath);
    initDomElements(dirList);
}

export function drawDirList(dirList) {
    let backVisibility = curDirStr.length > 5 ? 'inline' : 'none';
    $('#navBack').css('display',backVisibility); 
    $('#wdFiles').empty();

    for (const index in dirList) {
        let dirChar = dirList[index][1][0] == '/' ? '/': '';
        let look=dirList[index][0]+dirChar;
        let href='/'+curDirStr+'/'+look+(dirChar.length ? 'index':'');
        if (!dirChar.length) 
            href = href.substring(0,href.lastIndexOf('.'));
        let clknav =  dirChar.length 
            ? "<span class='clicknav' onclick='allFuncs.cdtonum("+index+");'>📁</span>&nbsp;&nbsp;"
            : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        $("#wdFiles").append("<li>"
            +clknav+"<a href='" 
            + href 
            +"' id='pid"+(index)
            +"' class='sel"
            + dirList[index][1].substring(1)
            +"'>"+look
            +"</a></li>");
    }
    $("#curDirStr").text(curDirStr);
    initDomElements(dirList);
}

export let hamDrawMenu = () => {
    document.cookie = "dialog=on; SameSite=None; Secure; path=/";
    keyb.setCurkeyhandler(keyb.KeyHandler.NAV);
    curDirStr=location.pathname.length>1 ? location.pathname.substring(1): defaultPage; // : never happends
    curDirStr = curDirStr.split('/').slice(0,-1).join('/');
    if (curDirStr == 'progs/edit')
        curDirStr = 'pages'
    keyb.clearSelDataPath();
    $("#myModal").css('display','block');
    isFirstDraw=true;
    hideInput();
    request(APIName,'ls','&curdir='+curDirStr,rsp.showDataDir); 
}

export let hideInput = () => {
    $("#statusLine").css('display','block');
    $("#txtinputlabel").css('display','none');
    $("#txtinput").css('display','none');
}

export function initDomElements(dirList) {
    lid=[];
    let method = location.pathname.length >1 ? location.pathname.split('/').pop():'index'
    cid=0;
    for(const index in dirList) {
        lid[index]=document.getElementById("pid"+index);
        if (isFirstDraw && dirList[index][0].split('.').shift() == method) 
            cid = (+index);
    }
    isFirstDraw=false;
    lid[cid].focus();
    statusLine();
    permStatSel=rsp.curDir[cid][4];
    lidInverse();
}

export let lidInverse = () => {
    let color= $(lid[cid]).css("color");
    $(lid[cid]).css("backgroundColor",color).css("color","white");
}


export let lidNormal = () => {
    let color= $(lid[cid]).css("backgroundColor");
    $(lid[cid]).css("backgroundColor","white").css("color",color);
}

export function loggedInOwnsSel() {
    if (permStatSel & 1)
        return true;
    //statusLine("you dont owns selected");
    return false;
}

export let quitMenu = () => {
    $('#myModal').css('display','none');
    $("#wdFiles").empty();
    keyb.setCurkeyhandler(keyb.KeyHandler.NOMENU);
    document.cookie = "dialog=off; path=/; SameSite=None; Secure";
}

export let setCurDirStr = (val) =>  curDirStr=val

export function showInput(prompt, validateFunc=frm.hasLength) {
    frm.setValiDateFunc(validateFunc);
    $("#statusLine").css('display','none');
    $("#txtinputlabel").css('display','block').text(prompt);
    $("#txtinput").css('display','block').focus();
    $("#txtinput").attr('value','');
}

export async function statusLine(mes='',delay=0) {
    $("#statusLine").css('display','block');
    let permstrs = ['--','-o','r-','ro'];
    let permstat = permstrs[rsp.dirPermStat] + '/' + permstrs[rsp.curDir[cid][4]] ;
    let defText= (cid !== undefined && rsp.curDir[cid] !== undefined)
        ? (cid+1+'/'+rsp.curDir.length+' '+rsp.curDir[cid][2]+'  '+permstat+"<br>"+rsp.curDir[cid][3]) 
        : 'snip curDir[cid] snap';
    if (mes.length) {
        $("#statusLine").html(mes);
        if (delay != 0) {
            await new Promise(res => setTimeout(res, delay));
            $("#statusLine").html(defText);
        }
    } else
        $("#statusLine").html(defText);
}

export function toEditMode(mode) {
    request(APIName,'setSessionVar','&sessionvar=editmode&editmode='+mode,rsp.setEditMode);
}
