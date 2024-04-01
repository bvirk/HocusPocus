import * as view from './dirView.js';

export function edit([file,editLoc]) {
    view.statusLine(file+' served as '+editLoc);
    if (editLoc == 'http' && (view.dirlist[view.selIndex][4] & 1)) {
        window.open('/progs/edit/content','_blank');
    }
    
}