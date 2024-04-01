import * as view from './dirView.js';
import * as fm from './filemanage.js';
import {getRequest} from './requests.js';
import {APIName,SES } from './webPageContext.js'
import dirWR from "./dirlistWebRoot.js";

export function whenWebRoot(event) {
    if (event.defaultPrevented)
        return; // Do nothing if the event was already processed
    switch(event.key) {
        case "Enter":
            view.closeDialog(view.urlOfFile(dirWR.selFileItem()[0]));
            break;
        case "ArrowDown":
            event.preventDefault();
            view.selectBelow();
            break;
        case "ArrowLeft":
            view.selectWRParentFolder();
            break;
        case "ArrowRight":
            view.selectWRSubFolder();
            break;
        case "ArrowUp":
            event.preventDefault();
            view.selectAbove();
            break;
        case "a":
            view.statusLine(SES.editmode);
            break;
        case "e":
            let file = dirWR.selFileItem()[0];
            getRequest(fm.edit,APIName+'edit&filetoedit='+file);
            break;
        case "q":
        case "Escape":
            view.closeDialog();
        default:
    }
    //event.preventDefault();
}



