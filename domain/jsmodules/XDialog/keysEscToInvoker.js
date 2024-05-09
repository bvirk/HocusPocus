import { KeyHandler, setCurkeyhandler, returnToKeyhandler } from "./keyHandlerDelegater.js"
import { statusLine } from './dirView.js'
import * as frm from './formsubmit.js'


export function whenEscapeToInvoker(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "Escape":
            frm.hideAllInput();
            statusLine('');
            setCurkeyhandler(returnToKeyhandler);
            break;
        case "a":
            console.log('a pressed');
            break;
        default:
            return;
    }
}
