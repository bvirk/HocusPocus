import { whenNoDialog } from './keysNoDialog.js'
import { whenWebRoot } from './keysWebRoot.js'
import { whenExtTypes } from './keysExtTypes.js';
import { whenExtFiles } from './keysExtFiles.js'

let curkeyhandler;
let lastCurkeyhandler;

window.addEventListener("keydown", delegateEListener,true);

function delegateEListener(event) {
    return curkeyhandler(event);
}
                                                                                                              
export const KeyHandler = Object.freeze({
    WEBROOT: whenWebRoot,
    NODIALOG: whenNoDialog,
    EXTTYPES: whenExtTypes,
    EXTFILES: whenExtFiles
});

export function setCurkeyhandler(func) { 
    curkeyhandler=func; 
}
