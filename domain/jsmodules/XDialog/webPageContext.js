import {statusLine} from './dirView.js';
/**
 * Variables and constants used in webpage and exposed from api.
 * php constants (defines) - identical name and value
 * php $_X super globals arrays - becomes X={key:value}
 *   fork.: _SESSION: SES, _SERVER: SER 
 * php simple values get identical name=vales
 */

export let APIName = "/?path=progs/NNNAPI/";
export let IS_PHP_ERR;
export let CONFIRM_COMMAND;




function listProps() {
    return stringifyObject(this);
}

export function primeWebPageContext({_IS_PHP_ERR}) {
    IS_PHP_ERR = _IS_PHP_ERR;
    CONFIRM_COMMAND = _IS_PHP_ERR;
}

export function setWebPageContext([err,obj]) {
    if (err === IS_PHP_ERR) {
        statusLine(obj);
        return false;
    }
    for (const pr in obj)
            this[pr] = obj[pr];
    return true;
}

function stringifyObject(obj) {
    let result = '';

    for (const key in obj) {
        if (typeof obj[key] !== 'function')
            result += typeof obj[key] === 'object'
                ? `${key}: {${stringifyObject(obj[key])}}, `
                : `${key}: ${obj[key]}, `;
    }
    return result;
}

const module = {listProps, setWebPageContext};
export default module;