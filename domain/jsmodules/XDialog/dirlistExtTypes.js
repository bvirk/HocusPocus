const dirlist = [
     {"file":"css","styleClass":"css","desc":"css files"}
    ,{"file":"js","styleClass":"js","desc":"js files"}
    ,{"file":"img","styleClass":"img","desc":"img files"}];

export function cacheSelFile() {
}

export function dirlistData(drawer) {
        drawer({dirlist:dirlist},true);
}
export function setDirty() { return module;}

export function typeName() { 
    return dirlist[this.selIndex]['file']; 
}

const module = { cacheSelFile, dirIndex: 0, length: 3, selIndex: 0, dirlistData, setDirty, typeName };
export default module;