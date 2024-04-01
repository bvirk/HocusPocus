import * as view from './dirView.js';
import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import * as fm from './filemanage.js';
import {getRequest} from './requests.js';
import {APIName,SES } from './webPageContext.js'
import dirExtFiles from "./dirlistExtFiles.js";

export function whenExtFiles(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "ArrowDown":
            event.preventDefault();
            view.selectBelow();
            break;
        case "ArrowLeft":
        case "e":
            let file = dirExtFiles.selFileItem()[0];
            getRequest(fm.edit,APIName+'edit&filetoedit='+file);
            break;
        case "q":
        case "Escape":
            setCurkeyhandler(KeyHandler.WEBROOT);
            view.fetchWebRoot(true);
            break;
        //case "ArrowRight":
        //    view.selectSubFolder();
        //    //view.statusLine('traet');
        //    break;
        case "ArrowUp":
            event.preventDefault();
            view.selectAbove();
            break;
        default:
    }
    //event.preventDefault();
}



