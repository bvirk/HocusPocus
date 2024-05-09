import * as view from './dirView.js';
import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import dirlistExtTypes from './dirlistExtTypes.js';
import { commonKeys } from './keysCommon.js';

export function whenExtTypes(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    commonKeys(event);
    switch(event.key) {
        case "ArrowLeft":
            dirlistExtTypes.selIndex=0;
            setCurkeyhandler(KeyHandler.WEBROOT);
            view.fetchWebRoot();
            break;
        case "ArrowRight":
            view.selectExtFiles();
            break;
        default:
    }
    //event.preventDefault();
}



