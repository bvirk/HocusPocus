import conf from './webPageContext.js';
import { statusLine } from './dirView.js';
import dirWR from "./dirlistWebRoot.js";

export function loggedinIsApacheUser() {
    if (conf.APACHE_USER === conf.SES.loggedin)
        return true;
    statusLine(`only ${conf.APACHE_USER} is authorized`);
    return false;
}

export function loggedInOwnsSel() {
    if (dirWR.selFileItem().filePermstat & 1)
        return true;
    statusLine("you dont owns selected");
    return false;
}

export function someIsLoggedin() {
    if (conf.SES.loggedin == '') {
        statusLine("logged in required");
        return false;
    }
    return true;
}
