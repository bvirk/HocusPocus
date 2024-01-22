export function apiEncode(mes) {
    let s=''
    // permitted is: '='  ';'  ':'  '/'  a-z, A-Z
    // transfer: '.' -> |
    // transfer: ' ' -> '_'
    for (let i=0; i<mes.length; i++) {
        let c=mes[i];
        s += (c>='a' && c <= 'z') || (c>='A' && c <= 'Z') || (c>='0' && c <= '9') || c == '=' || c == ';' || c == ':' || c == '/' || c == "\\" || c == '(' || c == ')' || c == '[' || c == ']' 
            ? c 
            : c == '.' 
                ? '|'
                : c == ' ' 
                    ? '_' 
                    : ''; 
    }
    return s;
}

export function convertToHex(str) {
    let hex = '';
    let delim='';
    for(var i=0;i<str.length;i++) {
        hex += delim+str.charCodeAt(i).toString(16);
        delim=' ';
    }
    return hex;
}

// convert a Unicode string to a string in which
// each 16-bit unit occupies only one byte
export function toBinary(string) {
    const codeUnits = new Uint16Array(string.length);
    for (let i = 0; i < codeUnits.length; i++) {
      codeUnits[i] = string.charCodeAt(i);
    }
    return String.fromCharCode(...new Uint8Array(codeUnits.buffer));
}

