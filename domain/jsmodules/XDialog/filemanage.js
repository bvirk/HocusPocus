import * as view from './dirView.js';

export function edit([file,editLoc]) {
    view.statusLine(file+' served as '+editLoc);
    if (editLoc == 'http' && (view.dirlist[view.selIndex][4] & 1)) {
        window.open('/progs/edit/content','_blank');
    }
    
}

export function webRootHelp([unused,resp]) {
    $('#dialog').css('display','none');
    $('#dialog-help').html(resp).css('display','block');

}