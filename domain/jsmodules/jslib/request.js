import { toBinary } from "./encodings.js";
export let  httpRequest;
export function request(apiPath,method,args,callBack) { 
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert("Cannot create an XMLHTTP instance");
        return false;
    }
    httpRequest.onreadystatechange = callBack;
    httpRequest.open("GET", '//'+location.hostname+apiPath+'/'+method+args);
    httpRequest.send();
}

export function postString(apiPath, method,filename,content,callBack) { 
    httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        alert("Cannot create an XMLHTTP instance");
        return false;
    }
    httpRequest.onreadystatechange = callBack;
    httpRequest.open("POST", '//'+location.hostname+apiPath+'/'+method,true);
    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    let base64=btoa(toBinary(content));
    let postmes="filetoedit="+filename+"&content="+base64;
    const blob = new Blob([postmes], { type: "text/plain" });
    httpRequest.send(blob);
}

