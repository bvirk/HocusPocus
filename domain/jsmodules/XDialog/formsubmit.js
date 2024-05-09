
import dirWR from "./dirlistWebRoot.js";
import { curkeyhandler, KeyHandler, returnToKeyhandler, setCurkeyhandler } from './keyHandlerDelegater.js';
import { dirname } from "./filemanage.js";
import { apiAnswer, postRequest} from './requests.js';
import { APIClass } from "./webPageContext.js";
import { attLoginButton, loginSignup } from './buttons.js';
import { basename, extension } from './filemanage.js'

let validateFunc;
//let invokeKeyhandler;

export function hasLength(txtinput) {
    if (txtinput.length)
        return true;
    statusLine('must have length');
    return false;
}

export function hasSameExt(txtinput) {
    let selfile = dir.selFileItem().file;
    let selExt = extension(selfile)
    if (selExt === extension(txtinput))
        return true;
    return txtinput+'.'+selExt;
}

export function hideAllInput() {
    $('#loginsignup').hide();
    $('#loginform').children().each( (index, element) => $(element).hide());
    $("#txtinputlabel").hide();
    $("#txtinput").hide();
}

export function isDataFileFormat(txtinput) {
    let dotPos = txtinput.lastIndexOf('.');
    if (dotPos == -1 || ['.md','.php'].indexOf(txtinput.substring(dotPos)) == -1) {
        statusLine('A data file name must have extension md or php');
        return false;
    }
    return true; 
}

export function is3Digits(txt) {
    if (/^\d{3}$/.test(txt))
        return true;
    statusLine('input must be 3 digits');
    return false;
}

function differs(txtinput) {
    if (txtinput === basename(dirWR.selFileItem().file)) {
        statusLine('must differ');
        return false;
    }
    return true;
}

export function isNewFile(txtinput) {
    return isDataFileFormat(txtinput) && differs(txtinput);
}

export function isNewDir(txtinput) {
    return isWithoutDot(txtinput) && differs(txtinput) && hasLength(txtinput);
}

export function isWithoutDot(txtinput) {
    if (txtinput.indexOf('.') == -1 )
        return true;
    statusLine('input must not contain a dot');
    return false;
}

export let setValiDateFunc = func => validateFunc=func

export function showLoginInput() {
    loginSignup(true);
    statusLine('');
    setCurkeyhandler(KeyHandler.ESCTOINVOKER,curkeyhandler);
    $('#loginsignup').show();
    $('#loginform').children().each( (index, element) => $(element).show());
    $('#uname').val('');
    $('#password').val('');
    
}

export function show1LineInput(cmd, prompt, event, validateFunc=hasLength, invokingKeyHandler=KeyHandler.WEBROOT) {
    event.preventDefault();
    statusLine('');
    $("#command").attr("value",cmd);
    $("#selname").attr("value",dir.selFileItem().file);
    setValiDateFunc(validateFunc);
    setCurkeyhandler(KeyHandler.ESCTOINVOKER,invokingKeyHandler);
    $("#txtinputlabel").css('display','block').text(prompt);
    $("#txtinput").css('display','block').focus();
    $("#txtinput").val('');
}

export function submitLogin(event) {
    event.preventDefault();
    setCurkeyhandler(returnToKeyhandler);
    let credidentals = {uname:event.target['uname'].value,password:event.target['password'].value}
    hideAllInput();
    if ($('#loginform input[type="submit"]').attr('value') === 'Login')
        postRequest(attLoginButton,credidentals,APIClass+'login');
    else
        postRequest(statusLine,credidentals,APIClass+'saveEncryption');
}   

export function submit1LineInput(event) {
    //return;
    event.preventDefault();
    setCurkeyhandler(returnToKeyhandler);
    let txtinput=event.target['txtinput'].value;
    hideAllInput();
    let valAct = validateFunc(txtinput);
    if (valAct) {
        if (typeof(valAct) == 'string')
            txtinput = valAct;
        let parms = { 
            dir:dirname(dir.selFileItem().file)
            ,txtinput:txtinput
            ,selname:event.target['selname'].value};
        postRequest(apiAnswer,parms,APIClass+event.target['command'].value);
    }
}

