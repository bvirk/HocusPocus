import { request } from "../jslib/request.js"
import * as rsp from "./reqCallBacks.js";
import * as keyb  from "./keyboard.js";
import * as dlg from "./dialog.js"

export function submitAll(event) {
    event.preventDefault();
    keyb.setCurkeyhandler(keyb.KeyHandler.NAV);
    dlg.hideInput();
    let parms = '&curdir='
        +dlg.curDirStr
        +'&txtinput='
        +event.target['txtinput'].value
        +'&selname='    // used for rename - doesn't do anything for other commands
        +event.target['selname'].value;
    let method=event.target['command'].value;
    
    request(dlg.APIName,method,parms,rsp.nopJSCommand);
    
};
