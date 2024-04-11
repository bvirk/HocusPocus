
function setProps([obj]) {
    for (const pr in obj)
        this[pr] = obj[pr];
}

function stringifyObject(obj) {
    let result = '';

    for (const key in obj) {
        if (typeof obj[key] !== 'function')
            result += typeof obj[key] === 'object'
                ? `${key}: {${stringifyObject(obj[key])}}, `
                : `${key}: ${obj[key]}, `;
    }
    return result;
}

function listProps() {
    return stringifyObject(this);
}


function setplace() {
    let [look,newplace] = this.place == 'file'
        ? ['🌥 ☑','http']
        : ['🌥 ☐','file']; 
    $('#editplace').text(look);
    this.place = newplace;
    
}


const module = { place:"file", setplace }; 

export default module;

