import * as dirView from './dirView.js';
import { setCurkeyhandler, KeyHandler }  from './keyHandlerDelegater.js'
import { primeWebPageContext, setEditMode } from './webPageContext.js'; 

$('#root').html(`
<script>var wobj={};</script>
<button id='openDialog' onClick='wobj.openDialog();'>☰</button>
<div id="dlgBG">
    <div id="dialog">
        <button id='closeDialog' onClick='wobj.closeDialog();'>X</button>\n
        <div id='headNav'>
            <span title="Home page" ><a id='navHome' onClick ='wobj.cdhome();'>⌂ </a></span>
            <span title="One level up"><a id='navBack' onClick='wobj.cdback();'>⏪</a></span>
            <span title="login"><a id='login' href='dummy'></a></span>
            <span><a id='editplace' >dummy</a><span>
        </div>
        <div id='curDirStr'></div>
        <ul id='wdFiles'></ul>
        <div id='statusLine'><div>
    </div>
</div>
`);
setCurkeyhandler(KeyHandler.NODIALOG);
wobj.openDialog     = dirView.openDialog;
wobj.closeDialog    = dirView.closeDialog;
wobj.cdtonum        = dirView.cdtonum;
wobj.cdback         = dirView.selectWRParentFolder;
wobj.cdhome         = dirView.cdhome;
wobj.toEditMode     = setEditMode;
primeWebPageContext({'_IS_PHP_ERR': $('#root').attr('data-IS_PHP_ERR')});
let dialogState=document.cookie.split('; ').find((row) => row.startsWith('dialog='))?.split('=')[1];
if ( dialogState == 'on' && location.pathname != '/progs/edit/content') 
    dirView.openDialog();

