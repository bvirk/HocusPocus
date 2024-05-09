import {statusLine} from './dirView.js';
/**
 * Variables and constants used in webpage and exposed from api.
 * php constants (defines) - identical name and value
 * php $_X super globals arrays - becomes X={key:value}
 *   fork.: _SESSION: SES, _SERVER: SER 
 * php simple values get identical name=vales
 */

export let APIName = "/?path=progs/NNNAPIObj/";
export let APIClass = "/progs/NNNAPIObj/";
export let PHP_ERR;


function listProps() {
    return stringifyObject(this);
}

export function primeWebPageContext(phpErrKey) {
    PHP_ERR = phpErrKey
}

export function setWebPageContext(obj) {
    for (const pr in obj)
        this[pr] = obj[pr];
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