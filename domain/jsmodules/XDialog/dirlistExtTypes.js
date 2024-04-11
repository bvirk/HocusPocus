let dirlist = [[
     ['css','+css','css files','',0]
    ,['js' ,'+js' ,'js files','',0]
    ,['img','+img','image files','',0]]];


export function cacheSelFile() {
}

export function dirlistData(drawer) {
        drawer(dirlist,true);
}
export function setDirty() { return module;}

export function typeName() { 
    return dirlist[0][this.selIndex][0]; 
}

const module = { cacheSelFile, dirIndex: 0, length: 3, selIndex: 0, dirlistData, setDirty, typeName };
export default module;