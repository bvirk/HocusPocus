import dirWR from "./dirlistWebRoot.js";
import dirExtFiles from "./dirlistExtFiles.js";
import dirExtTypes from './dirlistExtTypes.js';
import buts from './buttons.js';
import * as fm from './filemanage.js';
import * as frm from './formsubmit.js';

import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import conf, { APIClass, PHP_ERR } from './webPageContext.js'
import { postRequest } from './requests.js';


export let dir; // function to chosendir

/**
 * Only for webroot dir
 */
export let wRPath;

export function dirname(path) {
    let spos = path.lastIndexOf('/');
    return spos != -1 ? path.substring(0,spos) : path;
}

export function cdhome() {
    // this most be have dir context
    wRPath = 'data/pages';
    fetchWebRoot();
}

export function cdtonum(num) {
    wRPath += '/'+fm.basename(dirWR.fileItem(num).file);
    fetchWebRoot();
}

export function closeDialog(url) { // must be called from WR context 
    document.getElementById("dlgBG").style.display = 'none';
    //dir.setDirty();

    document.cookie = "dialog=off; path=/; SameSite=None; Secure";
    setCurkeyhandler(KeyHandler.NODIALOG);
    if (url) 
        window.location = url;
}

function choseDir(f) {
    dir=f;
    return f;
}

function draw({someDirHasDir, permstat, dirlist},fromCache) {
    if (!fromCache)
        dir.store({someDirHasDir, permstat, dirlist});
    if ( dir == dirExtTypes)
        drawExttypes(dirlist);
    else  if ( dir == dirExtFiles)
        drawExtFiles(dirlist)
    else { // dir = dirWR
        $('#wdFiles').empty();
        dirlist.forEach((e,index) => { 
            let look = fm.basename(e.file)+ (e.isDir ? '/':'');
            let href = '/?path=progs/mkPage&amp;redir='+urlOfFile(e.file);
            let className=(index == dir.selIndex ? 'sel': 'unsel')+e.styleClass;
            let clknav =  e.isDir
                ? "<span class='clicknav' onclick='wobj.cdtonum("+index+");'>📁</span>&nbsp;&nbsp;"
                : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            $("#wdFiles").append(`
                <li>${clknav}
                <a href='${href}' id='pid${index}' class='${className}'>${look}</a>
                </li>
            `);
        });
        let selPath = dirlist[dir.selIndex].file;
        let lslPos =selPath.lastIndexOf('/');
        $('#curDirStr').text(lslPos == -1 ? 'Document Root':selPath.substring(0,lslPos));
        let permstrs = ['--','-o','r-','ro'];
        let permstatStr = permstrs[permstat] + '/' + permstrs[dirlist[dir.selIndex].filePermstat];
        let message = (dir.selIndex +1)+'/'+ dirlist.length 
            +' '+dirlist[dir.selIndex].desc
            +' '+permstatStr
            + (dirlist[dir.selIndex].linksTo ? ' '+dirlist[dir.selIndex].linksTo:'') 
            +"<br>"+dirlist[dir.selIndex].enheritClass;
        fileInfoLine(message);
    }
}

function drawExtFiles(dirlist) {
    let dirLen=dirlist.length;
    $('#wdFiles').empty();
    dirlist.forEach((e,index) => {
        let look = fm.basename(e.file);
        let className=(index == dir.selIndex ? 'sel-': 'unsel-')+ dir.type+ (e.eFlag== 'e' ? '-ex' : '-mis')
        let href = '/'+e.file;
        $("#wdFiles").append(`
            <li><a href='${href}' id='pid${index}' class='${className}'>${look}</a></li>
        `);
    });
    let selPath = dirlist[dir.selIndex].file;
    let lslPos =selPath.lastIndexOf('/');
    $('#curDirStr').html('Datafile: '+dirWR.selFileItem().file+'<br>Path: '+selPath.substring(0,lslPos));
    let message = (dir.selIndex +1)+'/'+ dirLen +' '+dirlist[dir.selIndex].desc;
    fileInfoLine(message);
}

function drawExttypes(dirlist) {
    let dirLen=dirlist.length;
    $('#wdFiles').empty();
    dirlist.forEach((e,index) => {
        let className=(index == dir.selIndex ? 'sel': 'unsel')+e.styleClass;
        $("#wdFiles").append(`
            <li><span class='${className}'>${e.file}</span></li>
        `);
    });
    let message=dirlist[dir.selIndex].desc +' of ' +dirWR.selFileItem().file;
    fileInfoLine(message);
}

export function fetchWebRoot(useUrlPath=false) {
    if (useUrlPath)
        dirWR.useUrlPath();
    choseDir(dirWR);
    fetchDir();
}

export function fetchDir() {
    dir.setDirty().dirlistData(draw);
}

function fileInfoLine(mes) {
    $('#fileInfo').css('display','block').html(mes);
}

export function openDialog() {
    document.cookie = "dialog=on; SameSite=None; Secure; path=/";
    frm.hideAllInput();
    document.getElementById("dlgBG").style.display = 'block';
    $('#wdFiles').empty();
    setCurkeyhandler(KeyHandler.WEBROOT);
    dirWR.clearDirCache();
    statusLine('');
    postRequest(openDialogWithPageContext,{},APIClass+'pageContext');   
}

function openDialogWithPageContext(pageContext) {
    conf.setWebPageContext(pageContext)
    wRPath='data'+dirname(location.pathname);
    choseDir(dirWR);
    buts.attLoginButton();
    buts.attButEditmode();
}

export function selectAbove() {
    statusLine('');
    dir.selIndex -= dir.selIndex ? 1 : 1-dir.length;
    dir.dirlistData(draw);
    dir.cacheSelFile();
}

export function selectBelow() {
    statusLine('');
    dir.selIndex += dir.selIndex < dir.length-1 ? 1 : 1-dir.length;
    dir.dirlistData(draw);
    dir.cacheSelFile();
}

export function selectWRParentFolder() {
    statusLine('');
    if (wRPath.length && (wRPath.length > 10 || conf.SES.loggedin == conf.APACHE_USER)) {
        let lastSlashPos = wRPath.lastIndexOf('/')
        wRPath = lastSlashPos == -1 ? '' : wRPath.substring(0,lastSlashPos);
        fetchWebRoot();
    }
}

export function selectWRSubFolder() {
    statusLine('');
    if (dirWR.selFileItem().isDir) {
        wRPath += (wRPath.length ? '/' : '')+fm.basename(dirWR.selFileItem().file);
        fetchWebRoot();
    } else if (wRPath.substring(0,10) == 'data/pages') 
        selectExtTypesDir();
}

export function selectExtTypesDir() {
    statusLine('');
    setCurkeyhandler(KeyHandler.EXTTYPES);
    choseDir(dirExtTypes).setDirty().dirlistData(draw);
}    

export function selectExtFiles() {
    statusLine('');
    let type = dir.typeName();
    setCurkeyhandler(type === 'img' ? KeyHandler.IMG : KeyHandler.CSSORJS);
    choseDir(dirExtFiles).setDirty().setBranch(type,dirWR.selFileItem().file).dirlistData(draw);
}

export function statusLine(mes) {
    if (Array.isArray(mes))
        mes = mes.join();
    if (typeof mes == 'object')
        mes = JSON.stringify(mes);
    $("#statusLine").html(mes);
}

export function test() {
    let k1 = 'kurt';
    let v1 = 'hansen';
    let k2 = 'gitte';
    let v2 = 'gotten';
    postRequest(statusLine,{},APIClass+'recievePost');
}

export function urlOfFile(datafile) {
    let dotPos = datafile.lastIndexOf('.');
    return dotPos != -1 ? datafile.substring(4,dotPos) : datafile.substring(4)+'/index';
}
