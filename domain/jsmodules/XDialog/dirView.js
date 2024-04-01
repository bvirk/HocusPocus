import dirWR from "./dirlistWebRoot.js";
import dirExtFiles from "./dirlistExtFiles.js";
import dirExtTypes from './dirlistExtTypes.js';

import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import {IS_PHP_ERR, APIName, SES, setWebPageContext, setEditMode, APACHE_USER } from './webPageContext.js'
import {getRequest} from './requests.js';


let dir; // function to chosendir

/**
 * Only for webroot dir
 */
export let wRPath;

function basename(path) {
    return path.split('/').reverse()[0];
}

function dirname(path) {
    let spos = path.lastIndexOf('/');
    return spos != -1 ? path.substring(0,spos) : path;
}

export function cdhome(num) {
    // this most be have dir context
    wRPath = 'data/pages';
    fetchWebRoot();
}

export function cdtonum(num) {
    wRPath += '/'+basename(dirWR.fileItem(num)[0]);
    fetchWebRoot();
}

export function closeDialog(url) { // must be called from WR context 
    document.getElementById("dlgBG").style.display = 'none';
    dir.setDirty();

    document.cookie = "dialog=off; path=/; SameSite=None; Secure";
    setCurkeyhandler(KeyHandler.NODIALOG);
    if (url) 
        window.location = url;
}

function choseDir(f) {
    dir=f;
    return f;
}
//let dirlist;

function draw(resp, fromCache) {
    if (!fromCache)
        dir.store(resp,resp[0] === IS_PHP_ERR);
    if (resp[0] === IS_PHP_ERR) { 
        if (resp[1].length)
            $("#statusLine").text(resp[1]);
    } else if ( dir == dirExtTypes)
        drawExttypes(resp);
    else if ( dir == dirExtFiles)
        drawExtFiles(resp)
    else { // dir = dirWR
        let dirlist;
        [dir.dirHasDir,dir.dirPermStat,dirlist] = resp;
        let dirLen = dirlist.length;
        $('#wdFiles').empty();
        dirlist.forEach((e,index) => { 
            let dirChar = e[1][0] == '/' ? '/': '';
            let look = basename(e[0])+dirChar;
            let href = '/?path=progs/mkPage&amp;redir='+urlOfFile(e[0]);
            let className=(index == dir.selIndex ? 'sel': 'unsel')+e[1].substring(1);
            let clknav =  dirChar.length 
                ? "<span class='clicknav' onclick='wobj.cdtonum("+index+");'>📁</span>&nbsp;&nbsp;"
                : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $("#wdFiles").append(`
                <li>${clknav}
                <a href='${href}' id='pid${index}' class='${className}'>${look}</a>
                </li>
            `);
        });
        let selPath = dirlist[dir.selIndex][0];
        let lslPos =selPath.lastIndexOf('/');
        $('#curDirStr').text(lslPos == -1 ? 'Document Root':selPath.substring(0,lslPos));
        let permstrs = ['--','-o','r-','ro'];
        let permstat = permstrs[dir.dirPermStat] + '/' + permstrs[dirlist[dir.selIndex][4]];
        let message = (dir.selIndex +1)+'/'+ dirLen +' '+dirlist[dir.selIndex][2]
           +' '+permstat+"<br>"+dirlist[dir.selIndex][3];
        statusLine(message);
    }
}
       

function drawExtFiles(resp) {
    let dirlist=resp;
    let dirLen=dirlist.length;
    $('#wdFiles').empty();
    dirlist.forEach((e,index) => {
        let look = basename(e[0]);
        let className=(index == dir.selIndex ? 'sel-': 'unsel-')+ dir.type+ (e[1]== 'e' ? '-ex' : '-mis')
        let href = '/'+e[0];
        $("#wdFiles").append(`
            <li><a href='${href}' id='pid${index}' class='${className}'>${look}</a></li>
        `);
    });
    let selPath = dirlist[dir.selIndex][0];
    let lslPos =selPath.lastIndexOf('/');
    $('#curDirStr').html('Datafile: '+dirWR.selFileItem()[0]+'<br>Path: '+selPath.substring(0,lslPos));
    let message = (dir.selIndex +1)+'/'+ dirLen +' '+dirlist[dir.selIndex][2];
    statusLine(message);
}


function drawExttypes(resp) {
    let dirlist=resp[0];
    let dirLen=dirlist.length;
    $('#wdFiles').empty();
    dirlist.forEach((e,index) => {
        let className=(index == dir.selIndex ? 'sel': 'unsel')+e[1].substring(1);
        $("#wdFiles").append(`
            <li><span class='${className}'>${e[0]}</span></li>
        `);
    });
    let message=dirlist[dir.selIndex][2]+' of ' +dirWR.selFileItem()[0];
    statusLine(message);
}

export function fetchWebRoot() {
    choseDir(dirWR).setDirty().dirlistData(draw);
    //dir.selIndex=7;
    //statusLine(`became X`);
}

export function openDialog() {
    document.cookie = "dialog=on; SameSite=None; Secure; path=/";
    document.getElementById("dlgBG").style.display = 'block';
    $('#wdFiles').empty();
    setCurkeyhandler(KeyHandler.WEBROOT);
    getRequest(pageContextreciever,APIName+'pageContext');   
}

function pageContextreciever(parsed) {
    if (setWebPageContext(parsed)) 
        openDialogAfterInit();
    else
        statusLine(parsed[1]);
}

function openDialogAfterInit() {
    wRPath='data'+dirname(location.pathname);
    let [loginHref,loginTitle,loginText] = SES.loggedin.length
        ? ['/?path=progs/loginRecieve/logout&url='+window.location.pathname,'log out '+SES.loggedin,'➝🔒']
        : ['/?path=progs/html/login&url='+window.location.pathname,'log in','➝🔓'];
    $('#login').attr('href',loginHref).attr('title',loginTitle).text(loginText);
    setEditMode();
    fetchWebRoot();
}

export function selectAbove() {
    dir.selIndex -= dir.selIndex ? 1 : 1-dir.length;
    dir.dirlistData(draw);
}

export function selectBelow() {
    dir.selIndex += dir.selIndex < dir.length-1 ? 1 : 1-dir.length;
    dir.dirlistData(draw);
}

export function selectWRParentFolder() {
    if (wRPath.length && (wRPath.length > 10 || SES.loggedin == APACHE_USER)) {
        let lastSlashPos = wRPath.lastIndexOf('/')
        wRPath = lastSlashPos == -1 ? '' : wRPath.substring(0,lastSlashPos);
        fetchWebRoot();
    }
}

export function selectWRSubFolder() {
    let selFileItem = dirWR.selFileItem();
    if (selFileItem[1][0] === '/') {
        wRPath += (wRPath.length ? '/' : '')+basename(selFileItem[0]);
        fetchWebRoot();
    } else if (wRPath.substring(0,10) == 'data/pages') {
        setCurkeyhandler(KeyHandler.EXTTYPES);
        choseDir(dirExtTypes).setDirty().dirlistData(draw);
    } 
}

export function selectExtFiles() {
    let type = dir.typeName();
    setCurkeyhandler(KeyHandler.EXTFILES);
    choseDir(dirExtFiles).setDirty().dirlistData(draw,type,dirWR.selFileItem()[0]);
    //statusLine(type);
}

export function statusLine(mes) {
    $("#statusLine").css('display','block');
    $("#statusLine").html(mes);
}

export function urlOfFile(datafile) {
    let dotPos = datafile.lastIndexOf('.');
    return dotPos != -1 ? datafile.substring(4,dotPos) : datafile.substring(4)+'/index';
}
