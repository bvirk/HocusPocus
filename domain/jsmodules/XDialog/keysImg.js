import * as view from './dirView.js';
import { setCurkeyhandler, KeyHandler } from "./keyHandlerDelegater.js"
import * as fm from './filemanage.js';
import { postRequest } from './requests.js';
import { APIClass } from './webPageContext.js'
import { show1LineInput, hasSameExt } from './formsubmit.js';
import { someIsLoggedin } from './auth.js';
import { commonKeys } from './keysCommon.js';

export function whenImg(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    commonKeys(event);
    switch(event.key) {
        case "h":
            postRequest(fm.webRootHelp,{type:'img'},APIClass+'help');
            setCurkeyhandler(KeyHandler.HELP,KeyHandler.IMG);
            break;
        case "r": {
            if (someIsLoggedin()) 
                show1LineInput('mvImg','rename:',event,hasSameExt,KeyHandler.IMG);
            break;
        }
        case "ArrowLeft":
            view.selectExtTypesDir();
            break;
        default:
    }
    //event.preventDefault();
}



