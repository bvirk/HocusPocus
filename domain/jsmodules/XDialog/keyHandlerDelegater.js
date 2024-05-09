import { whenCssOrJS } from './keysCssOrJs.js';
import { whenConfirmY } from './keysConfirmY.js';
import { whenExtTypes } from './keysExtTypes.js';
import { whenHelp } from './keysHelp.js'
import { whenImg } from './keysImg.js';
import { whenNewFileOrDir } from './keysNew.js';
import { whenNoDialog } from './keysNoDialog.js'
import { whenWebRoot } from './keysWebRoot.js'
import { whenEscapeToInvoker } from './keysEscToInvoker.js';


export let curkeyhandler;
export let returnToKeyhandler;

window.addEventListener("keydown", delegateEListener,true);

function delegateEListener(event) {
    return curkeyhandler(event);
}
                                                                                                              
export const KeyHandler = Object.freeze({
    WEBROOT:    whenWebRoot,
    NODIALOG:   whenNoDialog,
    EXTTYPES:   whenExtTypes,
    IMG:        whenImg,
    CSSORJS:    whenCssOrJS,
    HELP:       whenHelp,
    CONFIRM_Y:  whenConfirmY,
    NEWFILEORDIR: whenNewFileOrDir,
    ESCTOINVOKER: whenEscapeToInvoker
});

export function setCurkeyhandler(func,returnTo) { 
    curkeyhandler=func;
    if (returnTo)
        returnToKeyhandler=returnTo;
    $('#keyhandler').text(func.name);
}
