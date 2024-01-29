import { hamDrawMenu, statusLine,lidInverse,lidNormal,cdback,quitMenu,showInput,hideInput,APIName } from "./hamMenu.js";
import { request } from "../jslib/request.js";
import { showMenu, curDir,nopJSCommand,savedFiletoeditResponse } from "./reqCallBacks.js";

let curkeyhandler;

/**
 * Main nnn nagigation
 */

window.addEventListener("keydown", delegateEListener,true);

export const KeyHandler = Object.freeze({
    NAV: navigate,
    ESC: hasEscape,
    NOMENU: whenNoMenu,
    NEWFILEORDIR: newFileOrDir,
    DELETEFILEORDIR: deleteFileOrDir
});

export function setCurkeyhandler(func) { 
    curkeyhandler=func; 
    // alert('keyhandler now '+curkeyhandler.name);
}

function delegateEListener(event) {
    return curkeyhandler(event);
} 

function hasEscape(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            hideInput();
            statusLine();
            curkeyhandler=KeyHandler.NOMENU;
            break;
        default:
            return;
    }
}

function newFileOrDir(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            hideInput();
            statusLine();
            curkeyhandler=KeyHandler.NAV;
            break;
        case "d": // new directory
            if (isLoggedin) {
                $("#command").attr("value","mkDir");
                showInput();
                curkeyhandler=KeyHandler.ESC;
            }
            break;
        case "f": // new file
            if (isLoggedin) {
                //alert("making file in /data/"+curDirStr);
                $("#command").attr("value","newFile");
                showInput();
                curkeyhandler=KeyHandler.ESC;
            }
            break;
        default:
            return;
    }
}

function deleteFileOrDir(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            hideInput();
            statusLine();
            curkeyhandler=KeyHandler.NAV;
            break;
        case "y": // delete file or dir
            if (isLoggedin) {
                let command=curDir[cid][1].length ? 'rmDir' : 'rm';
                let args = '&curdir='+curDirStr+'&selname='+curDir[cid][0];
                request(APIName,command,args,nopJSCommand);
                curkeyhandler=KeyHandler.NAV;
            }
            break;
        default:
            return;
    }
}

function navigate(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    try {
        switch(event.key) {
            case "ArrowDown":
                    lidNormal();
                    cid += cid < curDir.length-1 ? 1 : 1-curDir.length;
                    lidInverse();
                    lid[cid].focus();
                    statusLine();
                break;
            case "ArrowUp":
                    lidNormal();
                    cid -= cid ? 1 : 1-curDir.length;
                    lid[cid].focus();
                    lidInverse();
                    statusLine();
                break;
            case "ArrowRight":
                    if (curDir[cid][1].length) {
                        $("#wdFiles").empty();
                        curDirStr += '/'+curDir[cid][0];
                        request(APIName,'ls','&curdir='+curDirStr,showMenu);
                    }
                break;
            case "ArrowLeft":
                    cdback();
                break;
            case "Enter":
                    let url='/'+curDirStr+'/'+curDir[cid][0];
                    if ( curDir[cid][1].length)
                        url +='/index';
                    else
                        url = url.split('.').shift();
                    document.cookie = "dialog=off; path=/";
                    window.location = url;
                break;
            case "Home":
                curDirStr='pages';
                request(APIName,'ls','&curdir=pages',showMenu);
                break;
            case "Escape":
                quitMenu();
                break;
            case "c": // toogle public
                if (curDir[cid][1].length)
                    statusLine('only file!')
                else {
                    let file = 'data/'+curDirStr+'/'+curDir[cid][0];
                    request(APIName,'tooglePublic','&file='+file,nopJSCommand);
                }
                break;
            case "e": // edit
                let filetoedit = 'data/'+curDirStr+'/'+curDir[cid][0]+(curDir[cid][1].length ? '/index.md':'');
                request(APIName,'edit','&filetoedit='+filetoedit,savedFiletoeditResponse);
                break;                                                                  
            case "n": // new file or directory 
                if (isLoggedin) {
                    statusLine("'f'ile/'d'ir?");
                    curkeyhandler=KeyHandler.NEWFILEORDIR;
                }    
                break;
            case "r": // rename file or dir
                if (isLoggedin) {
                    $("#command").attr("value",curDir[cid][1].length ? 'mvDir':'mv');
                    $("#selname").attr("value",curDir[cid][0]);
                    $("#txtinput").attr("value",curDir[cid][0]);
                    showInput();
                    curkeyhandler=KeyHandler.ESC;
                }    
                break;
            case "q":
                    quitMenu();
                break;
            case "t":
                    request(APIName,'emptyTrash','',nopJSCommand);
                break;
            case "x": // remove file or directory
                if (isLoggedin) {
                    statusLine("remove selected [Esc cancels]");
                    curkeyhandler=KeyHandler.DELETEFILEORDIR;
                }
                break;
            case "z": // undo trash - unified undo of all deletion to trash
                if (isLoggedin) {
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



