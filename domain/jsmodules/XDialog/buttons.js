import conf from './webPageContext.js'
import { getRequest } from './requests.js';
import { APIName, IS_PHP_ERR } from './webPageContext.js';

/*
add events and look to buttons

*/

export function attachClick(id,callback) {
    document.getElementById(id).addEventListener('click', () =>callback());
}    





function setupEditModeButton() {
    document.getElementById('editplace').addEventListener('click', () => {
        let newplace = conf.SES.editmode == 'file' ? 'http' : 'file';
        getRequest(setEditmode,APIName+'setSessionVar&sessionvar=editmode&editmode='+newplace);
    });
    setEditmode([0,conf.SES.editmode]);
}

function setEditmode([err,value]) {
    let myVal = value;
    if (err === IS_PHP_ERR)
        statusLine(value);
    else {
        conf.SES.editmode=value;
        let [title,look] = conf.SES.editmode == 'file' 
            ? ['click to edit online','🌥 ☐']
            : ['click to edit local','🌥 ☑'];
        $('#editplace').text(look).attr('title',title);    
    }
} 




function setupLoginButton() {
    document.getElementById('login').addEventListener('click', () =>loginLogout());

    let [loginTitle,loginText] = conf.SES.loggedin.length
        ? ['log out '+conf.SES.loggedin,'🔒']
        : ['log in','🔓'];
    $('#login').attr('title',loginTitle).text(loginText);
    $('#loggedin').html('&nbsp;'+conf.SES.loggedin);
}

function loginLogout() {
    let url=conf.SES.loggedin.length
        ? '/?path=progs/loginRecieve/logout&url='+window.location.pathname
        : '/?path=progs/html/login&url='+window.location.pathname;
    window.location = url;
}

const module = {setupEditModeButton,setupLoginButton}
export default module;