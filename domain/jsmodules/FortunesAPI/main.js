import { request, httpRequest  }    from "../jslib/request.js?cc";
window.coloredFortune = function (parm) {
    request('fortunesAPI','fortune',parm,setFortune)
};
function setFortune() {
    if (httpRequest.readyState !== XMLHttpRequest.DONE || httpRequest.status !== 200) 
        return;
    try {
        let [parm1,parm2]  = JSON.parse(httpRequest.responseText);
        if (parm1 == isPhpErr)
            alert(parm2+"\nerror file and line number in webroot/config/filetoedit.txt"); 
        else {
            let [color,fortune]=[parm1,parm2];
            $('h3').css('color',color).text(fortune);
        }
    } catch (e) {
        if (e.message.startsWith('JSON.parse'))
            alert(httpRequest.responseText);
        else
            alert('perhaps som javascript error');
    }
        
}
