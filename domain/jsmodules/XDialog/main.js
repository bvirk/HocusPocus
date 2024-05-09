import * as dirView from './dirView.js';
import { setCurkeyhandler, KeyHandler }  from './keyHandlerDelegater.js'
import { primeWebPageContext } from './webPageContext.js'; 
import { attachClick, loginSignup } from './buttons.js';
import { submit1LineInput, submitLogin } from "./formsubmit.js";
//import test from './test.js';

$('#root').html(`
<button id='openDialog'>☰</button>
<div id="dlgBG">
    <div id="dialog-help" data-type="unref" >XYZ</div>
    <div id="dialog">
        <button id='closeDialog'>X</button>\n
        <div id='headNav'>
            <span title="Home page" ><a id='navHome'>⌂ </a></span>
            <span title="One level up"><a id='navBack'>⏪</a></span>
            <span id='loginbox'><div><div>&#866;&nbsp;</div><div id='loggedin'></div></div><button id='login'></button></span>
            <span><button id='editplace' >🌥 ☐</button><span>
        </div>
        <div id='curDirStr'></div>
        <ul id='wdFiles'></ul>
        <div id='fileInfo'></div>
        <div id='keyhandler_statusLine'>
            <span id='keyhandler'></span>:&nbsp;
            <span id='statusLine'></span>
        </div>
        <form id='form'>
            <label id="txtinputlabel" for="txtinput">unassigned</label>
            <input id="txtinput" type="text" name="txtinput" value="">
            <input id="command" type="hidden" name="command">
            <input id="selname" type="hidden" name="selname" value="">
        </form>
        <button id='loginsignup'>Sign up</button>
        <form id='loginform'>
            <h3>Login</h3>
            <label id="unamelabel" for="uname" style="display:block">User</label>
            <input id="uname" type="text" name="uname" value="">
            <label id="passwordlabel" for="password" style="display:block">Password</label>
            <input id="password" type="password" name="password" value="">
            <input type="submit" value="login" style="display:none" />
        </form>
        
    </div>
</div>
`);
setCurkeyhandler(KeyHandler.NODIALOG);
attachClick('openDialog',dirView.openDialog);
attachClick('closeDialog',dirView.closeDialog);
attachClick('loginsignup',loginSignup);

document.getElementById("form").addEventListener("submit",submit1LineInput);
document.getElementById("loginform").addEventListener("submit",submitLogin);
//attachClick('navBack',dirView.selectWRParentFolder);
//attachClick('navHome',dirView.cdhome);
//wobj.cdtonum        = dirView.cdtonum;
primeWebPageContext($('#root').attr('data-phpErrorKey'));
let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
if ( dialogState == 'on' && location.pathname != '/progs/edit/content') 
    dirView.openDialog();

window.test = dirView.test;
