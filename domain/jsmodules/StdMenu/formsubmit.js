import { request } from "../jslib/request.js"
import * as rsp from "./reqCallBacks.js";
import * as keyb  from "./keyboard.js";
import * as dlg from "./dialog.js"


let validateFunc;

export let setValiDateFunc = func => validateFunc=func;

export function submitAll(event) {
    event.preventDefault();
    keyb.setCurkeyhandler(keyb.KeyHandler.NAV);
    let txtinput=event.target['txtinput'].value;
    dlg.hideInput();
    let parms = '&curdir='
        +dlg.curDirStr
        +'&txtinput='
        +txtinput
        +'&selname='    // used for rename - doesn't do anything for other commands
        +event.target['selname'].value;
    let method=event.target['command'].value;
    if (validateFunc(txtinput))
        request(dlg.APIName,method,parms,rsp.nopJSCommand);
    
};

export function isWithoutDot(txtinput) {
    if (txtinput.indexOf('.') == -1 )
        return true;
    dlg.statusLine('input must not contain a dot');
    return false;
}

export function isDataFileFormat(txtinput) {
    let dotPos = txtinput.lastIndexOf('.');
    if (dotPos == -1 || ['.md','.php'].indexOf(txtinput.substring(dotPos)) == -1) {
        dlg.statusLine('A data file name must have extension md or php');
        return false;
    }
    return true; 
}

export let hasLength = txtinput => txtinput.length

