import { whenNoDialog } from './keysNoDialog.js'
import { whenWebRoot } from './keysWebRoot.js'
import { whenExtTypes } from './keysExtTypes.js';
import { whenExtFiles } from './keysExtFiles.js'
import { whenHelp } from './keysHelp.js'

let curkeyhandler;
export let returnToKeyhandler;

window.addEventListener("keydown", delegateEListener,true);

function delegateEListener(event) {
    return curkeyhandler(event);
}
                                                                                                              
export const KeyHandler = Object.freeze({
    WEBROOT:    whenWebRoot,
    NODIALOG:   whenNoDialog,
    EXTTYPES:   whenExtTypes,
    EXTFILES:   whenExtFiles,
    HELP:       whenHelp
});

export function setCurkeyhandler(func,returnTo) { 
    curkeyhandler=func;
    if (returnTo)
        returnToKeyhandler=returnTo;
}
