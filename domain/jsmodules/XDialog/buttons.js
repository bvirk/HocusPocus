import conf from './webPageContext.js'
import { postRequest } from './requests.js';
import { APIClass, PHP_ERR } from './webPageContext.js';
import { showLoginInput } from './formsubmit.js';
import { cdhome, fetchWebRoot, statusLine, wRPath } from './dirView.js';


/*
add events and look to buttons

*/

export function attachClick(id,callback) {
    document.getElementById(id).addEventListener('click', () =>callback());
}    





function attButEditmode(obj) {
    if (obj === undefined) {
        document.getElementById('editplace').addEventListener('click', () => {
            postRequest(
                 attButEditmode.bind(this)
                ,{sessionvar:'editmode',editmode:this.editmode == 'file' ? 'http' : 'file'}
                ,APIClass+'setSessionVar');
        });
    } else 
        this.editmode=obj['editmode'];
    let [title,look] = this.editmode == 'file' 
        ? ['click to edit online','🌥 ☐']
        : ['click to edit local','🌥 ☑'];
    $('#editplace').text(look).attr('title',title);
        
}



export function attLoginButton(obj) {
    if (obj === undefined) {
        document.getElementById('login').addEventListener('click', () => {
            if (conf.SES.loggedin.length) {
                if (conf.APACHE_USER === conf.SES.loggedin && wRPath.substring(0,10) !== 'data/pages')
                    cdhome();
                postRequest(
                    attLoginButton.bind(this)
                   ,{sessionvar:'loggedin',loggedin:''}
                   ,APIClass+'setSessionVar');
            } else 
                showLoginInput();    
        });
    } else {
        conf.SES.loggedin = obj['loggedin'];
        if (conf.SES.loggedin === '' && 'status' in obj)
            statusLine({login:obj['status']});
    }
    let [loginTitle,loginText] = conf.SES.loggedin.length
        ? ['log out '+conf.SES.loggedin,'🔒']
        : ['log in','🔓'];
    $('#login').attr('title',loginTitle).text(loginText);
    $('#loggedin').html('&nbsp;'+conf.SES.loggedin);
    fetchWebRoot(obj === undefined ? true : undefined);
}

export function loginSignup(reset=false) {
    let [butlook,formh3,submit] = reset || $('#loginsignup').text() === 'Login'
        ? ['Sign up','Login','Login']
        : ['Login','Make Encryption of password','Save encryption'];
        $('#loginsignup').text(butlook);
        $('#loginform h3').text(formh3);
        $('#loginform input[type="submit"]').attr('value',submit);

}

const module = {attButEditmode,attLoginButton,editmode:'file'}
export default module;