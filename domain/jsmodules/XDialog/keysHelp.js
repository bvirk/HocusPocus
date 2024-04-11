import { setCurkeyhandler, returnToKeyhandler } from "./keyHandlerDelegater.js"

export function whenHelp(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "q":
        case "Escape":
            $('#dialog').css('display','block');
            $('#dialog-help').css('display','none');
            setCurkeyhandler(returnToKeyhandler);
            break;
        default:
    }
    //event.preventDefault();
}


