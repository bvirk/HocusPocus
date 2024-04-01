import {IS_PHP_ERR } from './webPageContext.js'

export async function getRequest(reciever,url) {
    const response = await fetch(url);
    const text = await response.text();
    try {
        //console.log('trying in fether');
        reciever(JSON.parse(text),false); // which not cathes - it will happend here.
    } catch(e) {
        reciever([IS_PHP_ERR,e.message.startsWith('JSON.parse')
            ? text
            : `${e.name}: ${e.message} at ${e.fileName}:${e.lineNumber}` 
        ],false);
    }
}

