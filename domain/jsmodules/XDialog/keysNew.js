import { KeyHandler, setCurkeyhandler } from "./keyHandlerDelegater.js"
import * as frm from './formsubmit.js'

export function whenNewFileOrDir(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "Escape": {
            setCurkeyhandler(KeyHandler.WEBROOT);
            break;
        }
        case "d": { // new directory
            event.preventDefault();
            frm.show1LineInput('mkDir', 'new directory',event,frm.isWithoutDot);
            break;
        }
        case "f": { // new file
            event.preventDefault();
            frm.show1LineInput('newFile', 'new file',event,frm.isDataFileFormat);
            break;
        }
        default:
    }
            //event.preventDefault();
}
        