import { statusLine, fetchWebRoot } from './dirView.js';
import dirWR from "./dirlistWebRoot.js";
import { setCurkeyhandler, returnToKeyhandler } from "./keyHandlerDelegater.js"
import { apiAnswer, postRequest } from './requests.js';
import { APIClass } from './webPageContext.js';

export function whenConfirmY(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "y": {
            let cmd = dirWR.selFileItem().isDir ? 'rmDir':'rm';
            let file=dirWR.selFileItem().file;
            let selIndex = dirWR.selIndex;
            let len = dirWR.length;
            statusLine(`${cmd} ${file} ${selIndex+1}/${len}`);
            dirWR.nextSelNum=selIndex < len -1 ? selIndex+1 : len-1;
            setCurkeyhandler(returnToKeyhandler);
            postRequest(apiAnswer,{file:file},APIClass+cmd);
            break;
        }
        case "Escape": {
            statusLine('');
            setCurkeyhandler(returnToKeyhandler);
            break;
        }
    }
}