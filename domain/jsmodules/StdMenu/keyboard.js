import { hamDrawMenu, statusLine,lidInverse,lidNormal,cdback,quitMenu,showInput,hideInput,APIName } from "./hamMenu.js";
import { request } from "../jslib/request.js";
import { showMenu, curDir,nopJSCommand,savedFiletoeditResponse } from "./reqCallBacks.js";

let curkeyhandler;

/**
 * Main nnn nagigation
 */
let  kmAfterN=false;
let  kmAfterX=false;


window.addEventListener("keydown", delegateEListener,true);

export const KeyHandler = Object.freeze({
    NAV: navigate,
    ESC: hasEscape,
    NOMENU: whenNoMenu
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
            curkeyhandler=KeyHandler.NOMENU
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
            case "Escape": // regret new or delete
                    statusLine();
                    kmAfterN = false;
                    kmAfterX = false;
                break;
            case "d": // new directory, after n
                if (kmAfterN && isLoggedin) {
                    kmAfterN=false;
                    $("#command").attr("value","mkDir");
                    showInput();
                    curkeyhandler=KeyHandler.ESC;
                }
                break;
            case "e": // edit
                let filetoedit = 'data/'+curDirStr+'/'+curDir[cid][0]+(curDir[cid][1].length ? '/index.md':'');
                request(APIName,'edit','&filetoedit='+filetoedit,savedFiletoeditResponse);
                break;                                                                  
            case "f": // new file, after n 
                if (kmAfterN && isLoggedin) {
                    //alert("making file in /data/"+curDirStr);
                    $("#command").attr("value","newFile");
                    showInput();
                    curkeyhandler=KeyHandler.ESC;
                    kmAfterN=false;
                }
                break;
            case "n": // new file or directory 
                if (!kmAfterN && isLoggedin) {
                    statusLine("'f'ile/'d'ir?");
                    kmAfterN=true;
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
                if (!kmAfterX && isLoggedin) {
                    statusLine("remove selected [Esc cancels]");
                    kmAfterX = true;
                }
                break;
            case "y": // confirm removing file or dir
                if ( kmAfterX) {
                    kmAfterX=false;
                    let command=curDir[cid][1].length ? 'rmDir' : 'rm';
                    let args = '&curdir='+curDirStr+'&selname='+curDir[cid][0];
                    request(APIName,command,args,nopJSCommand);
                }
                break;
            case "z": // undo trash - unified undo of all deletion to trash
                if (!kmAfterX && isLoggedin) {
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



