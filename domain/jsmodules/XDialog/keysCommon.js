import { closeDialog, selectBelow, selectAbove  } from './dirView.js';

export function commonKeys(event) {
    switch(event.key) {
        case "ArrowDown":
            event.preventDefault();
            selectBelow();
            break;
        case "ArrowUp":
            event.preventDefault();
            selectAbove();
            break;
        case "q":
        case "Escape":
            closeDialog();
            break;
        
    }
    
}
