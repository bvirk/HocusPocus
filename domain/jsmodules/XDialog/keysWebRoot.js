import { statusLine, fetchWebRoot } from './dirView.js';
import * as  view from './dirView.js';
import * as fm from './filemanage.js';
import { apiAnswer, postRequest } from './requests.js';
import conf, { APIClass } from './webPageContext.js'
import dirWR from "./dirlistWebRoot.js";
import { KeyHandler, setCurkeyhandler } from './keyHandlerDelegater.js';
import { is3Digits, isWithoutDot, isNewFile, isNewDir, show1LineInput } from './formsubmit.js';
import { loggedinIsApacheUser, loggedInOwnsSel, someIsLoggedin } from './auth.js';
import { commonKeys } from './keysCommon.js';

export function whenWebRoot(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    commonKeys(event);
    switch(event.key) {
        case "Enter":
            view.closeDialog(view.urlOfFile(dirWR.selFileItem().file));
            break;
        case "ArrowLeft":
            view.selectWRParentFolder();
            break;
        case "ArrowRight":
            view.selectWRSubFolder();
            break;
        case "a": {
            if (loggedInOwnsSel())
                statusLine('you seems to be the owner');
            break;
        }
        case "d":
            postRequest(statusLine,{file:dirWR.selFileItem().file},APIClass+'du');
            break;
        case "e": {
            if (dirWR.selFileItem().isDir)
                statusLine('Must be regular file');
            else {
                let file = dirWR.selFileItem().file;
                postRequest(fm.edit,{filetoedit:file},APIClass+'edit');
            }
            break;
        }
        case "h":
            postRequest(fm.webRootHelp,{type:"nav"},APIClass+'help');
            setCurkeyhandler(KeyHandler.HELP,KeyHandler.WEBROOT);
            break;
        case "l": {

            break;
        }
        case "m": {
            if (loggedinIsApacheUser()) 
                show1LineInput('chmod','file mode:',event,is3Digits);
            break;
        }
        case "n": {
            let rejectMes = !(dirWR.permstat & 1) 
                ? "You don't owns containing dir"
                : (dirWR.selPathParts() < 3
                    ? "to high in dir"
                    : false);
            statusLine(rejectMes ? rejectMes : "'f'ile/'d'ir?");  
            if (!rejectMes)
                setCurkeyhandler(KeyHandler.NEWFILEORDIR,KeyHandler.WEBROOT);
            break;
        }
        case "o": {
            if (loggedinIsApacheUser()) 
                show1LineInput('chown','set owner:',event,isWithoutDot)
            break;
        }
        case "r": {
            if (loggedInOwnsSel()) {
                let selFile = dirWR.selFileItem().file;
                let isDir =  dirWR.selFileItem().isDir;
                if (!isDir && fm.barename(selFile) === 'index')
                    statusLine('index can not be renamed');
                else
                    show1LineInput(isDir ? 'mvDir': 'mv', 'rename to:',event, isDir ? isNewDir: isNewFile);
                    
            }
            break;
        }
        case "t": {
            if (someIsLoggedin())
                postRequest(view.statusLine,{},APIClass+'emptyTrash')
            break;
        }
        case "x": {
            let file=dirWR.selFileItem().file;
            let cmd=dirWR.selFileItem().isDir ? 'rmObjDir' : 'rmObj';
            if (cmd  == 'rmObj' && (fm.basename(file).split('.')[0] == 'index' || !!dirWR.selFileItem().isIndexTarget)) {
                view.selectWRParentFolder();
                statusLine('index is the folder that holds it');
                break;
            }
            let rejectMes =  !(dirWR.selFileItem().filePermstat & 1)
                ? 'You are not the owner'
                : (dirWR.selPathParts < 2 
                    ? 'to high in dir'
                    : (dirWR.selFileItem().dirHasDir
                        ? 'dir holds subdir - trash those first'
                        : false));
            if (rejectMes)
                statusLine(rejectMes);
            else {
                statusLine("remove selected [Esc cancels]");
                setCurkeyhandler(KeyHandler.CONFIRM_Y,KeyHandler.WEBROOT);
            }
            break;
        }
        case "z": {
            if (someIsLoggedin())
                postRequest(apiAnswer,{},APIClass+'undoTrash');
            break;
        }
        default:
    }
    //event.preventDefault();
}
  