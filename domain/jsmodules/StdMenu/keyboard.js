import * as dlg from "./dialog.js";
import { request } from "../jslib/request.js";
import * as rsp from "./reqCallBacks.js";
import * as frm from "./formsubmit.js";

let curkeyhandler;
let lastCurkeyhandler;
export let selDataPath;

window.addEventListener("keydown", delegateEListener,true);

export let clearSelDataPath = () => selDataPath=''

function cssOrJs(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
        case "ArrowLeft":
        case "q":
            lsDataDir();    
            break;
        case "ArrowDown":
            dlg.arrowDown(rsp.curDir.length);
            break;
        case "ArrowUp":
            dlg.arrowUp(rsp.curDir.length);
            break;
        case "e":
            let filetoedit = rsp.curDir[dlg.cid][0];
            request(dlg.APIName,'edit','&filetoedit='+filetoedit,rsp.savedFiletoeditResponse);
            break;
        case "h":
            help('cssOrJs',KeyHandler.CSSORJS);
            break;
        default:
            return;
    }
    event.preventDefault();
}



function delegateEListener(event) {
    return curkeyhandler(event);
} 

function deleteFileOrDir(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            toNavigate();
            break;
        case "y": // delete file or dir
            let command=rsp.curDir[dlg.cid][1][0] == '/' ? 'rmDir' : 'rm';
            let isIndex = command == 'rmDir' 
                ? false
                : (rsp.curDir[dlg.cid][0].split('.')[0] == 'index'
                    ? true
                    : false);
            let numSlash = dlg.curDirStr.split('/').length-1;
            if (numSlash==0 || (numSlash==1 && isIndex)) {
                dlg.statusLine("delete language or any default page thereoff not allowed");
                curkeyhandler=KeyHandler.NAV;
                break;
            }
            let args = '&curdir='+dlg.curDirStr+'&selname='+rsp.curDir[dlg.cid][0];
            request(dlg.APIName,command,args,rsp.nopJSCommand);
            curkeyhandler=KeyHandler.NAV;
            break;
        default:
            return;
    }
}

function hasEscape(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            toNavigate();
            break;
        default:
            return;
    }
}

function help(type,keyhandler) {
    lastCurkeyhandler = keyhandler;
    $('#modal-content').css('display','none');
    if ($('#dialog-help').attr('data-type') != type) {
        request(dlg.APIName,'help','&type='+type,rsp.importHelp);
        $('#dialog-help').attr('data-type',type);
    } 
    $('#dialog-help').css('display','block');
    curkeyhandler =KeyHandler.HELPLEAVER;
}

function helpLeaver(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
        case "q":
            $('#dialog-help').css('display','none');
            $('#modal-content').css('display','flex');
            curkeyhandler =lastCurkeyhandler;
            break;
        default:
            return;
    }
    event.preventDefault();
}

function img(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
        case "ArrowLeft":
        case "q":
            lsDataDir();    
            break;
        case "ArrowDown":
            dlg.arrowDown(rsp.curDir.length);
            break;
        case "ArrowUp":
            dlg.arrowUp(rsp.curDir.length);
            break;
        case "h":
            help('img',KeyHandler.IMG);
            break;
        case "r": // rename file or dir
            if (dlg.loggedInOwnsSel()) {
                let selFile=rsp.curDir[dlg.cid][0];
                let defInp = selFile.substring(selFile.lastIndexOf('/')+1);
                $("#command").attr("value",'mvImg');
                $("#selname").attr("value",selFile);
                $("#txtinput").attr("value",defInp);
                dlg.showInput('rename to:',KeyHandler.IMG,frm.ensureSameExtension);
                curkeyhandler=KeyHandler.ESC;
            } else
                dlg.statusLine('you are not the user');
            break;
        case "u":
            if (dlg.permStatSel==1) {  
                let selDataPathDir=selDataPath.substring(0,selDataPath.lastIndexOf("."));
                let url= `/?path=progs/uploadForm&refer=${location.pathname}&updest=img/${selDataPathDir}`;
                window.location = url; 
                //dlg.statusLine(url);
            } else
                dlg.statusLine("You are not the file owner");
            break;
        default:
            return;
    }
    event.preventDefault();
}

function isLoggedIn() {
    if (isLoggedin) {
        return true;
    }
    dlg.statusLine('not logged in',2000);
    return false;
}

export const KeyHandler = Object.freeze({
    NAV: navigate,
    ESC: hasEscape,
    NOMENU: whenNoMenu,
    NEWFILEORDIR: newFileOrDir,
    DELETEFILEORDIR: deleteFileOrDir,
    REFS: refs,
    CSSORJS: cssOrJs,
    HELPLEAVER: helpLeaver,
    IMG: img
});

function loggedInOwnsDirOfSel() {
    if (rsp.dirPermStat & 1)
        return true;
    dlg.statusLine("you dont owns dir of selected");
    return false;
}

function loggedInIsAdmin() {
    if (loggedInIsApache)
        return true;
    dlg.statusLine("logged in must be www-data");
    return false;
}


function lsDataDir(dir = undefined) {
    //alert(dir);
    if (dir)
        dlg.setCurDirStr(dir)
    //alert(dlg.curDirStr);
    request(dlg.APIName,'ls','&curdir='+dlg.curDirStr,rsp.showDataDir);
    curkeyhandler=KeyHandler.NAV;
}

function navigate(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    try {
        switch(event.key) {
            case "ArrowDown":
                dlg.arrowDown(rsp.curDir.length);
                break;
            case "ArrowUp":
                dlg.arrowUp(rsp.curDir.length);
                break;
            case "ArrowRight":
                    if (rsp.curDir[dlg.cid][1][0] == '/') 
                        lsDataDir(dlg.curDirStr + '/'+rsp.curDir[dlg.cid][0]);
                    else {
                        selDataPath=dlg.curDirStr+'/'+rsp.curDir[dlg.cid][0];
                        curkeyhandler=KeyHandler.REFS;
                        dlg.drawRefTypes();
                        dlg.statusLine("chose reference type");
                    }
                break;
            case "ArrowLeft":
                    dlg.cdback();
                break;
            case "Enter":
                    let url='/'+dlg.curDirStr+'/'+rsp.curDir[dlg.cid][0];
                    if ( rsp.curDir[dlg.cid][1][0] == '/')
                        url +='/index';
                    else
                        url = url.split('.').shift();
                    document.cookie = "dialog=off; path=/; SameSite=None; Secure;"
                    window.location = url;
                break;
            case "Home":
                lsDataDir('pages');
                break;
            case "Escape":
                dlg.quitMenu();
                break;
            case "b":
                dlg.statusLine('dirhasdir='+rsp.dirHasDir,1000);
                break;
            case "c": // toogle public
                if (dlg.loggedInOwnsSel()) {
                    if (rsp.curDir[dlg.cid][1][0] == '/')
                        dlg.statusLine('only file!')
                    else {
                        let args = '&curdir='+dlg.curDirStr+'&selname='+rsp.curDir[dlg.cid][0];
                        request(dlg.APIName,'tooglePublic',args,rsp.nopJSCommand);
                    }
                }
                break;
            case "e": // edit
                let filetoedit = 'data/'+dlg.curDirStr+'/'+rsp.curDir[dlg.cid][0]+(rsp.curDir[dlg.cid][1][0] == '/' ? '/index.md':'');
                request(dlg.APIName,'edit','&filetoedit='+filetoedit,rsp.savedFiletoeditResponse);
                break;  
            case "h": // help
                help('nav',KeyHandler.NAV);
                break;
            case "m": // modify file permission
                if (loggedInIsAdmin()) {
                    $("#command").attr("value",'chmod');
                    $("#selname").attr("value",rsp.curDir[dlg.cid][0]);
                    $("#txtinput").attr("value","");
                    dlg.showInput('file mode:',KeyHandler.NAV,frm.isDataFileFormat);
                    curkeyhandler=KeyHandler.ESC;
                }
                break;
            

            case "n": // new file or directory 
                if (loggedInOwnsDirOfSel() && !atTopDir()) {
                    dlg.statusLine("'f'ile/'d'ir?");
                    curkeyhandler=KeyHandler.NEWFILEORDIR;
                }    
                break;
            case "o": // set owner of file or dir
                if (loggedInIsAdmin()) {
                    $("#command").attr("value",'chown');
                    $("#selname").attr("value",rsp.curDir[dlg.cid][0]);
                    $("#txtinput").attr("value","");
                    event.preventDefault();
                    dlg.showInput('set owner:',KeyHandler.NAV,);
                    curkeyhandler=KeyHandler.ESC;
                }
                break;
            case "r": // rename file or dir
                if (dlg.loggedInOwnsSel()) {
                    let selFile=rsp.curDir[dlg.cid][0];
                    let isDir = rsp.curDir[dlg.cid][1][0] == '/';
                    if (!isDir && selFile.substring(0,selFile.indexOf('.')) == 'index') 
                        dlg.statusLine('index can not be renamed',2000);
                    else {
                        $("#command").attr("value",isDir ? 'mvDir':'mv');
                        $("#selname").attr("value",selFile);
                        $("#txtinput").attr("value","");
                        dlg.showInput('rename to:',KeyHandler.NAV,frm.differsFromSelectedAndHasLength);
                        curkeyhandler=KeyHandler.ESC;
                    }
                }    
                break;
            case "q":
                    dlg.quitMenu();
                break;
            case "t":
                if (isLoggedIn())
                    request(dlg.APIName,'emptyTrash','',rsp.nopJSCommand);
                break;
            case "x": // remove file or directory
                if (dlg.loggedInOwnsSel()) {
                    dlg.statusLine("remove selected [Esc cancels]");
                    curkeyhandler=KeyHandler.DELETEFILEORDIR;
                }
                break;
            case "z": // undo trash - unified undo of all deletion to trash
                if (isLoggedIn()) {
                    request(dlg.APIName,'undoTrash','',rsp.nopJSCommand);
                }
                break;
            default:
                break;
        }
        event.preventDefault();
        
    } catch(e) {
        if (!(e instanceof Error)) 
            e = new Error(e);
        dlg.statusLine(e.message);
    }
}

function newFileOrDir(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            toNavigate();
            break;
        case "d": // new directory
                $("#command").attr("value","mkDir");
                event.preventDefault();
                dlg.showInput('new directory:',KeyHandler.NAV,frm.isWithoutDot);
                curkeyhandler=KeyHandler.ESC;
            break;
        case "f": // new file
                $("#command").attr("value","newFile");
                event.preventDefault();
                dlg.showInput('new file:',KeyHandler.NAV,frm.isDataFileFormat);
                curkeyhandler=KeyHandler.ESC;
            break;
        default:
            return;
    }
}

function atTopDir() {
    if (dlg.curDirStr != 'pages')
        return false;
    dlg.statusLine('not permited at topdir');
    return true;
}

function refs(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
        case "ArrowLeft":
        case "q":    
            lsDataDir();
            break;
        case "ArrowDown":
            dlg.arrowDown(rsp.curDir.length);
            break;
        case "ArrowUp":
            dlg.arrowUp(rsp.curDir.length);
            break;
        case "ArrowRight":
            let type=rsp.curDir[dlg.cid][0];
            let callBack = type == 'css' || type == 'js' || type == 'img' ? rsp.showExtFiles : null;
            if (callBack !== null) {
                request(dlg.APIName,'lsExt','&selDataPath='+selDataPath+'&type='+type,callBack);
                curkeyhandler = type == 'img' 
                    ? KeyHandler.IMG
                    : KeyHandler.CSSORJS;
            } else 
                dlg.statusLine(rsp.curDir[dlg.cid][0]+' was not assigned');
            //
            break;
        default:
            return;
    }
    event.preventDefault();
}

export function setCurkeyhandler(func) { 
    curkeyhandler=func; 
}

function toNavigate() {
    dlg.hideInput();
    dlg.statusLine();
    curkeyhandler=KeyHandler.NAV;
}

function whenNoMenu(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "F9":
            dlg.hamDrawMenu();
            break;
        case "Enter":
            document.execCommand('insertText',false,"↵\n");
            break;
        default:
            return;
    }
}
