import {statusLine} from './dirView.js';
import { getRequest } from './requests.js';
/**
 * Variables and constants used in webpage and exposed from api.
 * php constants (defines) - identical name and value
 * php $_X super globals arrays - becomes X={key:value}
 *   fork.: _SESSION: SES, _SERVER: SER 
 * php simple values get identical name=vales 
 */
export const APIName = "/?path=progs/NNNAPI/";

export let IS_PHP_ERR;
export let CONFIRM_COMMAND;

export let defaultpage;
export let SES;  //{loggedin:,editmode:}
export let DEFAULTEDITMODE;
export let APACHE_USER;       
export let REDRAW_DIR;
export let REDRAW_IMG_DIR;
export let REDRAW_UPPERDIR;

export function primeWebPageContext({_IS_PHP_ERR}) {
    IS_PHP_ERR = _IS_PHP_ERR;
    CONFIRM_COMMAND = _IS_PHP_ERR;
}

export function setEditMode(loc) {
    if (loc)
        getRequest(setEditModeRecive,APIName+'setSessionVar&sessionvar=editmode&editmode='+loc);
    else
        setEditModeRecive(['',SES.editmode]);
}

function setEditModeRecive([unused,loc]) {
    SES.editmode=loc;
    let [editmodeIcon,editmodeTitle,editmodeOnClickParm] = SES.editmode === DEFAULTEDITMODE
    ? ['🌥 ☐','click to edit in browser','http']
    : ['🌥 ☑','click to edit locally only','file'];
    $('#editplace')
        .attr('title',editmodeTitle)
        .attr('onClick','wobj.toEditMode("'+editmodeOnClickParm+'");')
        .text(editmodeIcon);
}

export function setWebPageContext(resp) {
    if (resp[0] === IS_PHP_ERR) {
        statusLine(resp[1]);
        return false;
    } 
    defaultpage = resp[0];
    SES = {loggedin:resp[1],editmode:resp[2]}
    DEFAULTEDITMODE=resp[3];
    APACHE_USER=resp[4];
    REDRAW_DIR=resp[5];
    REDRAW_IMG_DIR=resp[6];
    REDRAW_UPPERDIR=resp[7];
    return true;
}
