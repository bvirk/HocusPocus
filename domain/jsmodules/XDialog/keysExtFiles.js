import * as view from './dirView.js';
import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import * as fm from './filemanage.js';
import { getRequest } from './requests.js';
import { APIName } from './webPageContext.js'
import dirExtFiles from "./dirlistExtFiles.js";
import dirExtTypes from './dirlistExtTypes.js';

export function whenExtFiles(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "ArrowDown":
            event.preventDefault();
            view.selectBelow();
            break;
        case "ArrowUp":
            event.preventDefault();
            view.selectAbove();
            break;
        case "e":
            let file = dirExtFiles.selFileItem()[0];
            getRequest(fm.edit,APIName+'edit&filetoedit='+file);
            break;
        case "h":
            let type = dirExtTypes.typeName() == 'img' ? 'img' : 'cssOrJs';
            getRequest(fm.webRootHelp,'/?path=progs/NNNAPI/help&type='+type);
            setCurkeyhandler(KeyHandler.HELP,KeyHandler.EXTFILES);
            break;
        case "q":
        case "Escape":
        case "ArrowLeft":
            view.selectExtTypesDir();
            //setCurkeyhandler(KeyHandler.WEBROOT);
            //view.fetchWebRoot(true);
            break;
        //case "ArrowRight":
        //    view.selectSubFolder();
        //    //view.statusLine('traet');
        //    break;
        default:
    }
    //event.preventDefault();
}



