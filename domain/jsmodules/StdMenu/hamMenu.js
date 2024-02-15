import { request }    from "../jslib/request.js";
import { showDataDir, curDir, setEditMode } from "./reqCallBacks.js";
import { setCurkeyhandler, KeyHandler } from "./keyboard.js"

export const APIName='/?path=progs/NNNAPI';
export let refTypes;
let isFirstDraw;

export function cdback(){
    if (curDirStr.length > /* 'pages' */ 5) { 
        let rpos=curDirStr.lastIndexOf('/');
        curDirStr = curDirStr.substring(0,rpos);
        $("#wdFiles").empty();
        request(APIName,'ls','&curdir='+curDirStr,showDataDir);
    }
}

export function cdhome(){
    curDirStr = 'pages';
    $("#wdFiles").empty();
    request(APIName,'ls','&curdir='+curDirStr,showDataDir);
}

export function cdtonum(num){
    curDirStr += '/'+curDir[num][0]
    //console.log(curDirStr);
    request(APIName,'ls','&curdir='+curDirStr,showDataDir);
}

export function drawRefTypes() {
    refTypes = [
         ['css'," abelist",'fsp','noclass']
        ,['js'," abelist",'fsp','noclass']
        ,['img'," abelist",'fsp','noclass']
    ];
    drawDirList(refTypes);
}
export function drawCssOrJsList(dirList) {
    //alert(dirList);
    //return;
    $('#navBack').css('display','inline'); 
    $('#wdFiles').empty();
    for (const index in dirList) {
        let look=dirList[index][0];
        let href =  dirList[index][1] == 'e' 
            ? '/?path=progs/html/source&file='+dirList[index][0]
            : '#';
        let [itemHead,itemTail] = ["<a href='" + href + "' ","</a>"];
        $("#wdFiles").append("<li>"
            +itemHead
            +"id='pid"+(index)
            +"' class='"+ dirList[index][1] + dirList[index][3]
            +"'>"+look+itemTail
            +"</li>");
    }
    $("#curDirStr").text(selDataPath);
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


export function hamDrawMenu() {
    document.cookie = "dialog=on; SameSite=None; Secure; path=/";
    setCurkeyhandler(KeyHandler.NAV);
    curDirStr=location.pathname.length>1 ? location.pathname.substring(1): defaultPage; // : never happends
    curDirStr = curDirStr.split('/').slice(0,-1).join('/');
    selDataPath='';
    $("#myModal").css('display','block');
    isFirstDraw=true;
    hideInput();
    request(APIName,'ls','&curdir='+curDirStr,showDataDir); 
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

export function showInput(prompt) {
    $("#statusLine").css('display','none');
    $("#txtinputlabel").css('display','block').text(prompt);
    $("#txtinput").css('display','block').focus();
}

export function hideInput() {
    $("#statusLine").css('display','block');
    $("#txtinputlabel").css('display','none');
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
