import * as view from './dirView.js'

export function whenNoDialog(event) {
    if (event.defaultPrevented)
        return;
    switch (event.key) {
        case "F9":
            view.openDialog();            
            break;
        case "Enter":
            document.execCommand('insertText',false,"↵\n");
            break;
        case "h":
            let hamvis = $('#openDialog').css('display');
            $('#openDialog').css('display',hamvis === 'block' ? 'none': 'block');
        default:
    }
}
