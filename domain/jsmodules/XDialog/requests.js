import {fetchDir, statusLine} from './dirView.js';
import {PHP_ERR } from './webPageContext.js'

export function apiAnswer(resp) {
    let mes='';
    let apiFunc = Object.keys(resp)[0];
    switch(apiFunc) {
        case 'mvImg': 
        case 'chmod':
        case 'chown':
        case 'mkDir':
        case 'mv':
        case 'mvDir':
            fetchDir();
            break;
        case 'du':
        case 'emptyTrash':
            break;
        default:
            mes = apiFunc+' not implemented';
    }
    statusLine(mes ? mes : JSON.stringify(resp));
}

export async function postRequest(reciever,data,url) {
    const formData = new URLSearchParams();
    
    for (const prop in data)
        formData.append(prop,data[prop]);     
    const options = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: formData.toString()
    };

    const response = await fetch(url, options);
    const text = await response.text();

    try {
        if (!text.length) {
            statusLine('empty response - had php Echoed?');
            return;
        }

        let resp=JSON.parse(text);
        if (PHP_ERR in resp)
            statusLine(resp);
        else
            reciever(resp,false); // which not cathes - it will happend here.
    } catch(e) {
        statusLine(e.message.startsWith('JSON.parse')
        ? text 
        : `${e.name}: ${e.message} at ${e.fileName}:${e.lineNumber}`);
    }
}
  