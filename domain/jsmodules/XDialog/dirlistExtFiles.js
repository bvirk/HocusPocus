import { APIClass } from './webPageContext.js'
import { postRequest } from './requests.js';


let cache;
let dirty=true;
let wRFile;

function cacheSelFile() {
}

function dirlistData(drawer) {
    if (dirty) {
        postRequest(drawer,{selDataPath:wRFile.substring(5),type:this.type}, APIClass+'lsExt');
    } else
        drawer(cache,true);
}
function selFileItem() {
    return dirty ? "no valid cache" :  cache.dirlist[this.selIndex];
}

function setBranch(type,_wRFile) {
    this.type = type;
    wRFile = _wRFile;
    return module;
}

function setDirty() { dirty=true; this.selIndex=0; return module;}

function store(newcache,newDirty) {
    cache=newcache;
    this.length = newcache['dirlist'].length;
    dirty=newDirty;
}

const module = { cacheSelFile, dirIndex: 0, length: 0, selIndex: 0, type:'', dirlistData, selFileItem, setBranch, setDirty, store };
export default module;