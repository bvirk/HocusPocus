import { APIName } from './webPageContext.js'
import { getRequest } from './requests.js';


let cache;
let dirty=true;

export function cacheSelFile() {
}

export function dirlistData(drawer,extType,selWRFile) {
    if (dirty) {
        this.type = extType;
        getRequest(drawer,APIName+'lsExt&selDataPath='+ selWRFile.substring(5) +'&type='+extType);
    } else
        drawer(cache,true);
}
export function selFileItem() {
    return dirty ? "no valid cache" :  cache[this.selIndex];
}

export function setDirty() { dirty=true; this.selIndex=0; return module;}

export function store(newcache,newDirty) {
    cache=newcache;
    this.length = cache.length;
    dirty=newDirty;
}

const module = { cacheSelFile, dirIndex: 0, length: 0, selIndex: 0, type:'', dirlistData, /* fileItem, */ selFileItem, setDirty, store };
export default module;