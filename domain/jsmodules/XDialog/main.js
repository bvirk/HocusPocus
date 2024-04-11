import * as dirView from './dirView.js';
import { setCurkeyhandler, KeyHandler }  from './keyHandlerDelegater.js'
import { primeWebPageContext } from './webPageContext.js'; 
import { attachClick } from './buttons.js';
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
        <div id='statusLine'><div>
    </div>
</div>
`);
setCurkeyhandler(KeyHandler.NODIALOG);
attachClick('openDialog',dirView.openDialog);
attachClick('closeDialog',dirView.closeDialog);
attachClick('navBack',dirView.selectWRParentFolder);
attachClick('navHome',dirView.cdhome);
//wobj.cdtonum        = dirView.cdtonum;
primeWebPageContext({'_IS_PHP_ERR': $('#root').attr('data-IS_PHP_ERR')});
let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
if ( dialogState == 'on' && location.pathname != '/progs/edit/content') 
    dirView.openDialog();
    
