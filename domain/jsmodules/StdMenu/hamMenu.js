import { request }    from "../jslib/request.js";
import { showMenu, curDir, setEditMode } from "./reqCallBacks.js";
import { setCurkeyhandler, KeyHandler } from "./keyboard.js"

export const APIName='/?path=progs/NNNAPI';
let isFirstDraw;

export function cdback(){
    if (curDirStr.length > /* 'pages' */ 5) { 
        let rpos=curDirStr.lastIndexOf('/');
        curDirStr = curDirStr.substring(0,rpos);
        $("#wdFiles").empty();
        request(APIName,'ls','&curdir='+curDirStr,showMenu);
    }
}

export function cdhome(){
    curDirStr = 'pages';
    $("#wdFiles").empty();
    request(APIName,'ls','&curdir='+curDirStr,showMenu);
}

export function cdtonum(num){
    curDirStr += '/'+curDir[num][0]
    //console.log(curDirStr);
    request(APIName,'ls','&curdir='+curDirStr,showMenu);
}

export function hamDrawMenu() {
    document.cookie = "dialog=on; SameSite=None; Secure; path=/";
    setCurkeyhandler(KeyHandler.NAV);
    curDirStr=location.pathname.length>1 ? location.pathname.substring(1): defaultPage; // : never happends
    curDirStr = curDirStr.split('/').slice(0,-1).join('/');
    $("#myModal").css('display','block');
    isFirstDraw=true;
    hideInput();
    request(APIName,'ls','&curdir='+curDirStr,showMenu); 
}

export function initDomElements() {
    lid=[];
    let method = location.pathname.length >1 ? location.pathname.split('/').pop():'index'
    cid=0;
    for(const index in curDir) {
        lid[index]=document.getElementById("pid"+index);
        if (isFirstDraw && curDir[index][0].split('.').shift() == method) 
            cid = (+index);
    }
    isFirstDraw=false;
    lid[cid].focus();
    statusLine();
    lidInverse();
}

export function lidInverse() {
    let color= $(lid[cid]).css("color");
    $(lid[cid]).css("backgroundColor",color).css("color","white");
}


export function lidNormal() {
    let color= $(lid[cid]).css("backgroundColor");
    $(lid[cid]).css("backgroundColor","white").css("color",color);
}

export function quitMenu() {
    document.getElementById("myModal").style.display = "none";
    $("#wdFiles").empty();
    setCurkeyhandler(KeyHandler.NOMENU);
    document.cookie = "dialog=off; path=/; SameSite=None; Secure";
}

export function showInput() {
    $("#statusLine").css('display','none');
    $("#txtinput").css('display','block').focus();
}

export function hideInput() {
    $("#statusLine").css('display','block');
    $("#txtinput").css('display','none');
}

export async function statusLine(mes='',delay=0) {
    $("#statusLine").css('display','block');
    let defText= (cid !== undefined && curDir[cid] !== undefined) 
        ? (cid+1+'/'+curDir.length+' '+curDir[cid][2]+"<br>"+curDir[cid][3]) 
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
    request(APIName,'setSessionVar','&sessionvar=editmode&editmode='+mode,setEditMode);
}
