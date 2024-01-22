import { hideInput, statusLine,APIName } from "./hamMenu.js"
import { request } from "../jslib/request.js"
import { nopJSCommand } from "./reqCallBacks.js";
import { setCurkeyhandler, KeyHandler } from "./keyboard.js";

export function submitAll(event) {
    event.preventDefault();
    setCurkeyhandler(KeyHandler.NAV);
    hideInput();
    let parms = '&curdir='
        +curDirStr
        +'&txtinput='
        +event.target['txtinput'].value
        +'&selname='    // used for rename - doesn't do anything for other commands
        +event.target['selname'].value;
    let method=event.target['command'].value;
    
    request(APIName,method,parms,nopJSCommand);
    
};
