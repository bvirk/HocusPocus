import { hamDrawMenu, statusLine,lidInverse,lidNormal,cdback,quitMenu,showInput,hideInput,drawRefTypes,refTypes,APIName } from "./hamMenu.js";
import { request } from "../jslib/request.js";
import { showDataDir, showCssOrJsFiles, curDir, nopJSCommand,savedFiletoeditResponse,importHelp } from "./reqCallBacks.js";

let curkeyhandler;
let lastCurkeyhandler;

window.addEventListener("keydown", delegateEListener,true);

function arrowDown(length) {
    lidNormal();
    cid += cid < length-1 ? 1 : 1-length;
    lidInverse();
    lid[cid].focus();
    statusLine();
}

function arrowUp(length) {
    lidNormal();
    cid -= cid ? 1 : 1-length;
    lid[cid].focus();
    lidInverse();
    statusLine();
}

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
            arrowDown(curDir.length);
            break;
        case "ArrowUp":
            arrowUp(curDir.length);
            break;
        case "e":
            let filetoedit = curDir[cid][0];
            request(APIName,'edit','&filetoedit='+filetoedit,savedFiletoeditResponse);
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
            let command=curDir[cid][1][0] == '/' ? 'rmDir' : 'rm';
            let isIndex = command == 'rmDir' 
                ? false
                : (curDir[cid][0].split('.')[0] == 'index'
                    ? true
                    : false);
            let numSlash = curDirStr.split('/').length-1;
            if (numSlash==0 || (numSlash==1 && isIndex)) {
                statusLine("delete language or any default page thereoff not allowed");
                curkeyhandler=KeyHandler.NAV;
                break;
            }
            let args = '&curdir='+curDirStr+'&selname='+curDir[cid][0];
            request(APIName,command,args,nopJSCommand);
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
        request(APIName,'help','&type='+type,importHelp);
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

function isLoggedIn() {
    if (isLoggedin) {
        return true;
    }
    statusLine('not logged in',2000);
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
    HELPLEAVER: helpLeaver
});

function lsDataDir(dir = undefined) {
    if (dir)
        curDirStr = dir
    request(APIName,'ls','&curdir='+curDirStr,showDataDir);
    curkeyhandler=KeyHandler.NAV;
}

function navigate(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    try {
        switch(event.key) {
            case "ArrowDown":
                arrowDown(curDir.length);
                break;
            case "ArrowUp":
                arrowUp(curDir.length);
                break;
            case "ArrowRight":
                    if (curDir[cid][1][0] == '/') 
                        lsDataDir(curDirStr + '/'+curDir[cid][0]);
                    else {
                        selDataPath=curDirStr+'/'+curDir[cid][0];
                        curkeyhandler=KeyHandler.REFS;
                        drawRefTypes();
                        statusLine("chose reference type");
                    }
                break;
            case "ArrowLeft":
                    cdback();
                break;
            case "Enter":
                    let url='/'+curDirStr+'/'+curDir[cid][0];
                    if ( curDir[cid][1][0] == '/')
                        url +='/index';
                    else
                        url = url.split('.').shift();
                    document.cookie = "dialog=off; path=/";
                    window.location = url;
                break;
            case "Home":
                lsDataDir('pages');
                break;
            case "Escape":
                quitMenu();
                break;
            case "b":
                statusLine('key "b" disabled',1000);
                break;
            case "c": // toogle public
                if (isLoggedIn()) {
                    if (curDir[cid][1][0] == '/')
                        statusLine('only file!')
                    else {
                        let args = '&curdir='+curDirStr+'&selname='+curDir[cid][0];
                        request(APIName,'tooglePublic',args,nopJSCommand);
                    }
                }
                break;
            case "e": // edit
                let filetoedit = 'data/'+curDirStr+'/'+curDir[cid][0]+(curDir[cid][1][0] == '/' ? '/index.md':'');
                request(APIName,'edit','&filetoedit='+filetoedit,savedFiletoeditResponse);
                break;  
            case "h": // help
                help('nav',KeyHandler.NAV);
                break;
            case "m": // modify file permission
                if (isLoggedIn()) {
                    $("#command").attr("value",'chmod');
                    $("#selname").attr("value",curDir[cid][0]);
                    $("#txtinput").attr("value","");
                    showInput('file mode:');
                    curkeyhandler=KeyHandler.ESC;
                }
                break;
            

            case "n": // new file or directory 
                if (isLoggedIn()) {
                    statusLine("'f'ile/'d'ir?");
                    curkeyhandler=KeyHandler.NEWFILEORDIR;
                }    
                break;
            case "o": // set owner of file or dir
                if (isLoggedIn()) {
                    $("#command").attr("value",'chown');
                    $("#selname").attr("value",curDir[cid][0]);
                    $("#txtinput").attr("value","");
                    showInput('set owner:');
                    curkeyhandler=KeyHandler.ESC;
                }
                break;
            case "r": // rename file or dir
                if (isLoggedIn()) {
                    $("#command").attr("value",curDir[cid][1][0] == '/' ? 'mvDir':'mv');
                    $("#selname").attr("value",curDir[cid][0]);
                    $("#txtinput").attr("value","");
                    showInput('rename to:');
                    curkeyhandler=KeyHandler.ESC;
                }    
                break;
            case "q":
                    quitMenu();
                break;
            case "t":
                if (isLoggedIn())
                    request(APIName,'emptyTrash','',nopJSCommand);
                break;
            case "x": // remove file or directory
                if (isLoggedIn()) {
                    statusLine("remove selected [Esc cancels]");
                    curkeyhandler=KeyHandler.DELETEFILEORDIR;
                }
                break;
            case "z": // undo trash - unified undo of all deletion to trash
                if (isLoggedIn()) {
                    request(APIName,'undoTrash','',nopJSCommand);
                }
                break;
            default:
                break;
        }
        event.preventDefault();
        
    } catch(e) {
        if (!(e instanceof Error)) 
            e = new Error(e);
        statusLine(e.message);
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
                showInput('new directory:');
                curkeyhandler=KeyHandler.ESC;
            break;
        case "f": // new file
                $("#command").attr("value","newFile");
                showInput('new file:');
                curkeyhandler=KeyHandler.ESC;
            break;
        default:
            return;
    }
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
            arrowDown(refTypes.length);
            break;
        case "ArrowUp":
            arrowUp(refTypes.length);
            break;
        case "ArrowRight":
            let type=refTypes[cid][0];
            let callBack = type == 'css' || type == 'js' ? showCssOrJsFiles : null;
            if (callBack !== null) {
                request(APIName,'lsExt','&selDataPath='+selDataPath+'&type='+type,callBack);
                curkeyhandler=KeyHandler.CSSORJS;
            } else 
                statusLine(refTypes[cid][0]+' was not assigned');
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
    hideInput();
    statusLine();
    curkeyhandler=KeyHandler.NAV;
}

function whenNoMenu(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "F9":
            hamDrawMenu();
            break;
        case "Enter":
            document.execCommand('insertText',false,"↵\n");
            break;
        default:
            return;
    }
}
