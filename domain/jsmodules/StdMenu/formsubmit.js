import { request } from "../jslib/request.js"
import * as rsp from "./reqCallBacks.js";
import * as keyb  from "./keyboard.js";
import * as dlg from "./dialog.js"

let validateFunc;
let keyhandler;

export let setValiDateFunc = func => validateFunc=func
export let setKeyHandler = func => keyhandler=func

export function submitAll(event) {
    event.preventDefault();
    keyb.setCurkeyhandler(keyhandler);
    let txtinput=event.target['txtinput'].value;
    dlg.hideInput();
    let method=event.target['command'].value;
    let valAct = validateFunc(txtinput);
    if (valAct) {
        if (typeof(valAct) == 'string')
            txtinput = valAct;
        let parms = '&curdir=' 
        +dlg.curDirStr
        +'&txtinput='
        +txtinput
        +'&selname='    // used for rename 
        +event.target['selname'].value;
        request(dlg.APIName,method,parms,rsp.nopJSCommand);
    }
}

export let differsFromSelectedAndHasLength = txtinput => 
    (txtinput != rsp.curDir[dlg.cid][0]) && txtinput.length > 0


export function isDataFileFormat(txtinput) {
    let dotPos = txtinput.lastIndexOf('.');
    if (dotPos == -1 || ['.md','.php'].indexOf(txtinput.substring(dotPos)) == -1) {
        dlg.statusLine('A data file name must have extension md or php');
        return false;
    }
    return true; 
}

export function isWithoutDot(txtinput) {
    if (txtinput.indexOf('.') == -1 )
        return true;
    dlg.statusLine('input must not contain a dot');
    return false;
}

export function ensureSameExtension(txtinput) {
    if (txtinput.length == 0)
        return false;
    let selPath = rsp.curDir[dlg.cid][0];
    let ext = selPath.substr(selPath.lastIndexOf('.'));
    let inputLastDotPos=txtinput.lastIndexOf('.');
    return txtinput.substring(0,(inputLastDotPos == -1 ? txtinput.length : inputLastDotPos))+ext;
} 

export let hasLength = txtinput => txtinput.length

