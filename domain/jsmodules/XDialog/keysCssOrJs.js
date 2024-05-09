import * as view from './dirView.js';
import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import * as fm from './filemanage.js';
import { postRequest } from './requests.js';
import { APIClass } from './webPageContext.js'
import dirExtFiles from "./dirlistExtFiles.js";
import { commonKeys } from './keysCommon.js';

export function whenCssOrJS(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    
    commonKeys(event);
    switch(event.key) {
        case "e":
            let file = dirExtFiles.selFileItem().file;
            postRequest(fm.edit,{filetoedit:file},APIClass+'edit');
            break;
        case "h":
            postRequest(fm.webRootHelp,{type:'cssOrJs'},APIClass+'help');
            setCurkeyhandler(KeyHandler.HELP,KeyHandler.CSSORJS);
            break;
        case "ArrowLeft":
            view.selectExtTypesDir();
            break;
        default:
    }
    //event.preventDefault();
}



