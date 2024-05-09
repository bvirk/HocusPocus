import * as view from './dirView.js';

export function edit({file,editLoc}) {
    view.statusLine(file+' served as '+editLoc);
    if (editLoc == 'http' && (view.dir.selFileItem().filePermstat & 1)) {
        window.open('/progs/edit/content','_blank');
    }
    
}


export function basename(path) {
    return path.split('/').reverse()[0];
}

export function barename(fileName) {
    let f= basename(fileName);
    return f.substring(0,f.lastIndexOf('.'));
}

export function dirname(path) {
    return path.split('/').slice(0,-1).join('/');
}

export function extension(fileName) {
    let f= basename(fileName);
    return f.substring(f.lastIndexOf('.')+1);
}

export function webRootHelp({content}) {
    $('#dialog').css('display','none');
    $('#dialog-help').html(content).css('display','block');

}
